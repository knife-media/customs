(function () {
  /**
   * Check if custom options defined
   */
  if (typeof knife_custom_wizard === 'undefined') {
    return false;
  }

  const header = document.querySelector('.header');

  if (header === null) {
    return false;
  }

  let form = null;

  /**
   * Show main wizard popup
   */
  function showPopup() {
    const popup = document.createElement('div');
    popup.classList.add('wizard');
    document.body.appendChild(popup);

    createFields(popup, () => {
      form.addEventListener('submit', handleForm);

      // Focus on text field
      form.querySelector('textarea').focus();

      document.body.classList.add('is-wizard');
    });

    // Listen to esc key
    popup.addEventListener('keydown', (e) => {
      if (e.key != 'Escape') {
        return;
      }

      document.body.classList.add('is-wizard');

      // Completely remove popup
      document.body.removeChild(popup);
    });

    const closer = document.createElement('button');
    closer.classList.add('wizard__closer');
    closer.setAttribute('type', 'button');
    popup.appendChild(closer)

    closer.addEventListener('click', (e) => {
      e.preventDefault();

      // Remove popup at all
      document.body.removeChild(popup);
    });
  }

  /**
   * Handle created form actions
   */
  function handleForm(e) {
    e.preventDefault();

    const request = new XMLHttpRequest();
    request.open('POST', knife_custom_wizard.url, true);
    request.setRequestHeader('Content-Type', 'application/json');

    request.onload = () => {
      try {
        const response = JSON.parse(request.responseText);

        if (request.status !== 200) {
          return showError(response.message || knife_custom_wizard.error);
        }

        return showSuccess(response.message);
      } catch (err) {
        console.error(err);
        return showError(knife_custom_wizard.error);
      }
    }

    const data = {
      question: form.querySelector('textarea').value,
    }

    request.send(JSON.stringify(data));
  }

  /**
   * Show message on success
   */
  function showSuccess(message) {
    while (form.firstChild) {
      form.removeChild(form.lastChild);
    }

    const title = document.createElement('h5');
    title.classList.add('wizard__title');
    title.textContent = knife_custom_wizard.title.result;
    form.appendChild(title);

    const answer = document.createElement('p');
    answer.classList.add('wizard__answer');
    answer.textContent = message;
    form.appendChild(answer);
  }

  /**
   * Handle form errors
   */
  function showError(message) {
    const warning = document.createElement('p');
    warning.classList.add('wizard__warning');
    warning.textContent = message;
    form.appendChild(warning);
  }

  /**
   * Create all required wizard forms
   */
  function createFields(popup, callback) {
    form = document.createElement('form');
    form.classList.add('wizard__form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', '/');
    popup.appendChild(form);

    const title = document.createElement('h2');
    title.classList.add('wizard__title');
    title.textContent = knife_custom_wizard.title.start;
    form.appendChild(title);

    const excerpt = document.createElement('h5');
    excerpt.classList.add('wizard__excerpt');
    excerpt.textContent = knife_custom_wizard.excerpt;
    form.appendChild(excerpt);

    const textarea = document.createElement('textarea');
    textarea.classList.add('wizard__textarea');
    textarea.setAttribute('placeholder', knife_custom_wizard.placeholder);
    form.appendChild(textarea);

    const submit = document.createElement('button');
    submit.classList.add('wizard__submit');
    submit.setAttribute('type', 'submit');
    submit.textContent = 'Узнать ответ';
    form.appendChild(submit);

    return callback();
  }

  let start = 0;

  header.addEventListener('click', () => {
    if (start === null || ++start < 3) {
      return;
    }

    start = null;
    showPopup();
  });
})();