<?php

if (!isset($user)) return;

// fields
$tags = get_user_meta($user->ID, 'instructor-speacialties-tags', true);
$tags = is_array($tags) ? $tags : [];
$aiAreaOfFocusDescription = get_user_meta($user->ID, 'instructor-speacialties-ai-area-of-focus-description', true);
$calendlyLink = get_user_meta($user->ID, 'instructor-calendly-link', true);
$instructor_is_available = get_user_meta($user->ID, 'instructor-is-available', true);
$instructor_profile_img_id = get_user_meta($user->ID, 'instructor-profile-img-id', true);
$instructor_img_src = "";
if ($instructor_profile_img_id) {
    $instructor_img_src = wp_get_attachment_image_src((int)$instructor_profile_img_id, 'full');
    $instructor_img_src = is_array($instructor_img_src) ? $instructor_img_src[0] : "";
}

?>

<h3>AIM Instructor Settings</h3>
<table class="form-table">


    <tr id="instructor-profile-img-row">
        <th>
            <label for="instructor-profile-img-id">Profile Image</label>
        </th>
        <td>
            <div style="max-width: 100px; display: flex; align-items: center; justify-content: center; flex-direction: column; gap:4px;">
                    <style>
                        img[src=""] {
                            visibility: hidden;
                        }
                    </style>
                    <img class="instructor-profile-img" src="<?= $instructor_img_src; ?>" alt="Profile Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #333;">

                <input type="hidden" name="instructor-profile-img-id" id="instructor-profile-img-id" value="<?= $instructor_profile_img_id; ?>">
                <button id="update-instructor-profile-img-button" class="button" type="button">Update</button>
            </div>
        </td>
    </tr>

    <tr>
        <th>
            <label for="instructor-is-available">Instructor is available</label>
        </th>
        <td>
            <input type="checkbox" name="instructor-is-available" id="instructor-is-available" value="1" <?php if ($instructor_is_available) echo 'checked'; ?>>
        </td>
    </tr>


    <tr>
        <th>
            <label for="instructor-speacialties-tags-input">Tags</label>
        </th>
        <td id="instructor-specialty-tags">
            <div class="tags-container" style="display: flex; flex-direction:column; gap: 8px;">
                <div class="tag-list">
                    <?php foreach ($tags as $tag): ?>
                        <button data-action="remove-tag" data-tag="<?= $tag; ?>" class="tag remove-tag button button-small">
                            <span class="tag"><?= $tag; ?></span>
                            <span class="text-icon">&times;</span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="instructor-speacialties-tags-value" name="instructor-speacialties-tags" value="<?= implode(",", $tags); ?>">
                <div>
                    <input type="text" id="instructor-speacialties-tags-input" name="new-tag" value="">
                    <button data-action="add-tag" type="button" class="tag add-tag button">Add</button>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <th>
            <label for="instructor-speacialties-ai-area-of-focus-description">AI Area of Focus</label>
        </th>
        <td>
            <textarea name="instructor-speacialties-ai-area-of-focus-description" id="instructor-speacialties-ai-area-of-focus-description" rows="5" cols="50"><?= $aiAreaOfFocusDescription; ?></textarea>
        </td>
    </tr>

    <tr>
        <th>
            <label for="instructor-calendly-link">Calendly Link</label>
        </th>
        <td>
            <input type="url" style="width:350px;" name="instructor-calendly-link" id="instructor-calendly-link" value="<?= $calendlyLink; ?>">
        </td>
    </tr>



</table>

<script>
    // you i just want to add js dont care about setting up another file/build process to add this bit of js.

    window.addEventListener('DOMContentLoaded', instructorSettings);

    function instructorSettings() {
        const tagsEl = document.getElementById('instructor-specialty-tags');
        if (tagsEl) {
            initTags(tagsEl)
        }

        const profileImgRowEl = document.getElementById('instructor-profile-img-row');
        if (profileImgRowEl) {
            initProfileImg(profileImgRowEl)
        }
    }

    function initTags(el) {
        const list = el.querySelector('.tag-list');
        const addButton = el.querySelector('.add-tag');
        const inputNewTag = el.querySelector('#instructor-speacialties-tags-input');

        const valueInput = el.querySelector('#instructor-speacialties-tags-value');
        list.addEventListener('click', function(e) {
            e.preventDefault();
            const target = e.target;
            console.log(target)
            if (target.tagName !== 'BUTTON' && !target.closest('.remove-tag')) return;
            console.log("has tag");
            const element = e.target.classList.contains('remove-tag') ? target : target.closest('.remove-tag');
            console.log("has class remove-tag");
            if (element.dataset.action !== 'remove-tag') return;
            console.log("has dataset action");
            const tag = element.dataset.tag;
            valueInput.value = valueInput.value.replace(`,${tag}`, '');
            element.parentNode.removeChild(element);
        });
        inputNewTag.addEventListener('keydown', function(e) {
            if (e.key !== 'Enter') return;
            e.preventDefault();
            const newtag = e.target.value;
            if (!newtag) return;
            valueInput.value += `,${newtag}`;
            inputNewTag.value = ''
            list.appendChild(createTag(newtag));
        });
        addButton.addEventListener('click', function(e) {
            console.log('add button clicked');
            const newtag = e.target.parentNode.querySelector('#instructor-speacialties-tags-input').value;
            if (!newtag) return;
            valueInput.value += `,${newtag}`;
            inputNewTag.value = ''
            list.appendChild(createTag(newtag));
        });
    }

    function createTag(tag) {
        const tagEl = document.createElement('button');
        tagEl.setAttribute('data-action', 'remove-tag');
        tagEl.setAttribute('data-tag', tag);
        tagEl.classList.add('tag', 'remove-tag');
        tagEl.innerHTML = `<span class="tag">${tag}</span><span class="text-icon">&times;</span>`;
        return tagEl;
    }

    function initProfileImg(el) {
        const updateButton = el.querySelector('#update-instructor-profile-img-button');
        const profileImgId = el.querySelector('#instructor-profile-img-id');
        const profileImg = el.querySelector('img.instructor-profile-img');
        updateButton.addEventListener('click', function(e) {
            e.preventDefault();
            const newProfileImgId = e.target.parentNode.querySelector('#instructor-profile-img-id').value;

            openMediaHandler(newProfileImgId, function(attachment) {
                console.log(attachment)
                profileImg.src = attachment.url;
                profileImgId.value = attachment.id;
            })

        })
    }

    function openMediaHandler(imageId, onSelect) {


        const customUploader = wp.media({
            title: 'Insert image', // modal window title
            library: {
                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                type: 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },

            multiple: false
        }).on('select', function() { // it also has "open" and "close" events
            const attachment = customUploader.state().get('selection').first().toJSON();
            onSelect(attachment)
        })

        // already selected images
        customUploader.on('open', function() {

            if (imageId) {
                const selection = customUploader.state().get('selection')
                const attachment = wp.media.attachment(imageId);
                attachment.fetch();
                selection.add(attachment ? [attachment] : []);
            }

        })

        customUploader.open()
    }
</script>
