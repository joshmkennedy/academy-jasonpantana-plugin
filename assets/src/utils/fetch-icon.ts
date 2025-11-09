export async function fetchIcon(slug: string): Promise<string> {
  return fetch('/wp-content/plugins/jp/assets/' + slug + '.svg')
    .then((response) => response.text())
}
