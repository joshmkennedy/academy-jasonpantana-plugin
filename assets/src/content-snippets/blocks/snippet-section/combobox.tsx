import { ComboboxControl, Spinner } from "@wordpress/components";
import { useState } from "@wordpress/element";

export type ComboboxOption = {
  value: string;
  label: string;
  subLabel?: string;
}

type ComboboxProps = {
  label: string;
  value: ComboboxOption['value'] | null;
  isLoading: boolean;
  options: ComboboxOption[];
  onSelect: (value: ComboboxProps['value'] | undefined) => void;
};

export function Combobox({
  label,
  isLoading,
  options,
  onSelect,
  value,
}: ComboboxProps) {

  const [filteredOptions, setFilteredOptions] = useState(options);

  return <div className="jp-blocks-combobox">
    <ComboboxControl
      label={isLoading ? "Fetching Options..." : label}
      value={value}
      onChange={onSelect}
      options={filteredOptions}
      __experimentalRenderItem={({ item }) => {
        return (
          <div key={item.value} className="jp-blocks-combobox__item " style={{
            display: "flex",
            justifyContent: "space-between",
            alignItems: "center",
          }}>
					<div>
            <p
              style={{
                fontSize: "12px",
                fontWeight: "bold",
                margin: 0,
              }}
            >
              {item.label}
            </p>
						{item.subLabel && <p style={{fontSize: "10px", margin: 0}}>{item.subLabel}</p>}
						</div>
          </div>
        );
      }}
      onFilterValueChange={(inputValue) => {
        const filterd = options.filter((option) => {
          if (inputValue.length < 2) return true;

          return option.label
            .toLowerCase()
            .includes(inputValue.toLowerCase());
        });
        setFilteredOptions(filterd);
      }}
    />
    {isLoading && <Spinner
      style={{
        width: `calc(4px * 8)`,
        height: `calc(4px * 8)`,
      }}
    />}
  </div>

}
