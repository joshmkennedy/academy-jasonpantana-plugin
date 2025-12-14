import { useEffect, useState, createRoot, useRef } from "@wordpress/element";
import { SearchControl, SelectControl } from '@wordpress/components';
import "./styles.css";

export function mountAimExpertTagInput(element: HTMLElement, taxonomy: string, allTags: Record<string, string>, userTags: string[]) {
  const root = createRoot(element);
  const userTagFormatted = userTags.map(t => Object.entries(allTags).find(([id]) => id == t)!)
    .reduce((acc, [id, name]) => ({ ...acc, [id]: name }), {} as Record<string, string>);
  root.render(<AimExpertTagInput allTags={allTags} userTags={userTagFormatted} taxonomy={taxonomy} />);
}

function AimExpertTagInput({ allTags, userTags, taxonomy }: { allTags: Record<string, string>, userTags: Record<string, string>, taxonomy: string }) {
  const element = useRef<HTMLDivElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);
  const [input, setInput] = useState<string>("")
  const [isOpen, setIsOpen] = useState(false)
  const [allTagsList, setAllTagsList] = useState(allTags);
  const [userTagsList, setUserTagsList] = useState(userTags);
  const filteredTags = Object.values(allTagsList).filter((tag) => tag.toLowerCase().includes(input?.toLowerCase() as string));
  const [] = useState(userTags);

  useEffect(() => {
    const inputEl = element.current?.closest('#instructor-specialty-tags')
      ?.querySelector<HTMLInputElement>(`[name="users-${taxonomy}-tags"]`)
    if (!inputEl) return;
    inputEl.value = JSON.stringify(userTagsList);
  }, [userTagsList]);

  useEffect(() => {
    if (!element.current) return;
    const closeOnClickOutside = (e: MouseEvent) => {
      if (element.current && !element.current.contains(e.target as Node)) {
        setIsOpen(false);
      }
    };
    document.addEventListener("click", closeOnClickOutside);
    return () => {
      document.removeEventListener("click", closeOnClickOutside);
    };
  }, [setIsOpen]);

  function addTag(tagid: string, tagName: string) {
    if (!tagid || !tagName) return;
    setUserTagsList({ ...userTagsList, [tagid]: tagName });
  }

  function removeFromUser(id: string, name: string) {
    delete userTagsList[id];
    setUserTagsList({ ...userTagsList });
  }

  function handleAddTag(tag?: string) {
    let inputTag = input;

    if (tag) {
      inputTag = tag;
    }

    if (!inputTag) {
      return;
    }
    if (filteredTags.length === 0) {
      const tag = Object.entries(allTagsList).find(([id, name]) => name == inputTag);
      if (tag) {
        addTag(tag[0], tag[1]);
        setInput("");
        return;
      }
      addTag(inputTag, inputTag);
    } else {
      const matchingtag = Object.entries(allTagsList).find(([id, name]) => name == inputTag);
      if (matchingtag) {
        addTag(matchingtag[0], matchingtag[1]);
        setInput("");
        return;
      }

      const tagName = filteredTags[0];
      const tag = Object.entries(allTagsList).find(([id, name]) => name == tagName);
      if (!tag) return;
      addTag(tag[0], tag[1]);
    }
    setInput("")
  }

  function handleEnterKey(e: KeyboardEvent) {
    if (e.key !== "Enter") return;
    e.preventDefault();
    handleAddTag();
    setIsOpen(false);
  }
  async function handleclear() {
    setInput("");
    inputRef.current?.focus();
    await new Promise(r => setTimeout(r, 100));
    setIsOpen(true);
  }

  return (
    <div ref={element} className="expert-select-input">
      <h3>{taxonomy.replaceAll("-", " ")}</h3>
      <div className="combo">
        <div className="input__outer-wrapper">
          <div className="input__inner-wrapper">
            {Boolean(input.length) && <button type="button" onClick={handleclear}>&times;</button>}
            <input
              ref={inputRef}
              id={`users-${taxonomy}-tags--inserter`}
              value={input ?? ""}
              onChange={(e) => setInput(e.target.value)}
              onFocus={() => setIsOpen(true)}
              // @ts-ignore
              onKeyDown={handleEnterKey}
            />
          </div>
          {input && <button type="button" className="add-button" onClick={() => handleAddTag()}>Add</button>}
        </div>
        {input.length > 0 &&
          <div className="components-form-token-field__suggestions-list">
            {filteredTags.map((tag) => (
              <li
                className="components-form-token-field__suggestion"
                key={tag}
              >
                <button
                  type="button"
                  onClick={() => {
                    handleAddTag(tag);
                  }}
                >
                  {tag}
                </button>
              </li>
            ))}
          </div>
        }
      </div>
      <div className="user-tags">
        {Object.entries(userTagsList).map(([id, name]) => (
          <div key={id} className="user-tag">
            <span>{name}</span>
            <button type="button" onClick={() => removeFromUser(id, name)}>&times;</button>
          </div>
        ))}
      </div>
    </div>
  );
}
