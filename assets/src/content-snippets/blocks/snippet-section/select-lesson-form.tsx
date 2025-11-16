import { Combobox, type ComboboxOption } from "./combobox";
import { useState } from "@wordpress/element";
import { useSelect } from "@wordpress/data";
import {type Post, type Term} from "@wordpress/core-data";

const POST_TYPE = "sfwd-lessons";
const CATEGORY = "ld_lesson_category";

export type SelectLessonFormProps = {
  onSubmit: (value: Post) => void;
}
export function SelectLessonForm({
  onSubmit,
}: SelectLessonFormProps) {

 const [ selectedLesson, setSelectedLesson ] = useState<Post|undefined>(undefined);
  const { terms, termsLoading } = useSelect( ( select ) => {
    const query = {
      per_page: -1,
    };

    return {
      terms: select( 'core' ).getEntityRecords( 'taxonomy', CATEGORY, query ),
      termsLoading: select( 'core' ).isResolving( 'core', 'getEntityRecords', [ 'taxonomy', CATEGORY, query ] ),
    };
  }, [] )

 const { posts, postsLoading } = useSelect( ( select ) => {
    const query = {
      per_page: -1,
      post_type: POST_TYPE,
			_embed: true,
    };

    return {
      posts: select( 'core' ).getEntityRecords( 'postType', POST_TYPE, query ),
      postsLoading: select( 'core' ).isResolving( 'core', 'getEntityRecords', [ 'postType', POST_TYPE, query ] ),
    };
  }, [] );

	const isLoading = postsLoading || termsLoading;

	console.log(posts);

  return <div>
    <h1>Select Lesson Form</h1>
    <form
			onSubmit={(e) => {
				e.preventDefault();
				if (selectedLesson) {
					onSubmit(selectedLesson);
				}
			}}
		>
      <Combobox
        label="Pick a Lesson to use it's content"
        isLoading={isLoading}
        options={!isLoading && posts?.length ? posts.map(postToOption) : []}
        value={selectedLesson?.id.toString() ?? null}
        onSelect={(value) => {
          if (value) {
						const post = posts?.find(post => post.id.toString() === value)
						setSelectedLesson(post);
          }
        }}
      />
			<button type="submit" className="button button-small" >Submit</button>
    </form>
  </div>
}

function postToOption(post: Post): ComboboxOption {
	const option:ComboboxOption = {
		value: post.id.toString(),
		label: post.title.raw,
	}
	if(post?._embedded['wp:term']?.length){
		const terms = post._embedded['wp:term'].map(tax => {
			return tax.map((term:Term)	=>{
				return term.name
			}).flat()
		})
		option.subLabel = terms.filter(Boolean).join(', ');
	}
	return option;
}
