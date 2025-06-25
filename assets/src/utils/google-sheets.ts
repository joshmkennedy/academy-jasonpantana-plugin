const CONFIG = {
  SHEET_ENDPOINT: 'https://script.google.com/macros/s/AKfycbwsFi5jd_JExJvGy9gf0CrC7emsQFfniRv_TvjBRig83fgs36IBsBIauY4Ak8h3zGGS/exec',
}

export default function submitToSheet(data: { firstName: string, lastName: string, email: string, url: string, title: string }) {
  console.log(data)
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = CONFIG.SHEET_ENDPOINT;
  form.target = 'hidden_iframe' + Date.now();
  form.style.display = 'none';

  const firstName = document.createElement('input');
  firstName.type = 'text';
  firstName.name = 'first_name';
  firstName.value = data.firstName;

  const lastName = document.createElement('input');
  lastName.type = 'text';
  lastName.name = 'last_name';
  lastName.value = data.lastName;

  const email = document.createElement('input');
  email.type = 'text';
  email.name = 'email';
  email.value = data.email;

  const url = document.createElement('input');
  url.type = 'text';
  url.name = 'url';
  url.value = data.url;

  const title = document.createElement('input');
  title.type = 'text';
  title.name = 'title';
  title.value = data.title;

  form.appendChild(firstName);
  form.appendChild(lastName);
  form.appendChild(email);
  form.appendChild(title);
  form.appendChild(url);

  form.style.display = 'none';
  document.body.appendChild(form);

  const iframe = document.createElement('iframe');
  iframe.name = form.target;
  // iframe.style.display = 'none';
  iframe.src = 'about:blank';
  document.body.appendChild(iframe);

  form.submit();
  iframe.onload = function () {
    document.body.removeChild(form);
    document.body.removeChild(iframe);
  }
}
