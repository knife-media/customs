(function () {
  /**
   * Check if custom options defined
   */
  if (typeof knife_custom_wizard === 'undefined') {
    return false;
  }

  const logo = document.querySelector('.header__logo-link');

  if (logo === null) {
    return false;
  }

  /**
   * Main popup
   */
  let popup = null

  /**
   * Shuffle given list
   */
  function shuffleList(array, index) {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      const temp = array[i];
      array[i] = array[j];
      array[j] = temp;
    }

    if (typeof index !== 'undefined') {
      return array[index];
    }

    return array;
  }

  /**
   * Check is popup recently shown
   */
  function getRecent() {
    let storage = window.localStorage.getItem('secret-wizard');

    if (storage === null) {
      return null;
    }

    storage = JSON.parse(storage);

    if (!storage.message || !storage.timestamp) {
      return null;
    }

    const current = Math.floor(Date.now() / 1000);

    // If current time more than saved + 24 hours
    if (current > (storage.timestamp + 3600 * 24)) {
      return null;
    }

    const message = storage.message;

    if (!message.title || !message.text) {
      return null;
    }

    return message;
  }

  /**
   * Show main wizard popup
   */
  function showPopup() {
    popup = document.createElement('div');
    popup.classList.add('wizard');
    document.body.appendChild(popup);

    const close = document.createElement('button');
    close.classList.add('wizard__close');
    close.setAttribute('type', 'button');
    popup.appendChild(close);

    const adminbar = document.getElementById('wpadminbar');

    if (adminbar && window.scrollY < adminbar.clientHeight) {
      close.style.marginTop = (adminbar.clientHeight - window.scrollY) + 'px';
    }

    const scrollTop = window.scrollY;

    // Set body login class
    document.body.classList.add('is-login');
    document.body.style.top = -scrollTop + 'px';

    function closeWizard() {
      document.body.classList.remove('is-login');
      document.body.style.top = '';
      document.body.removeChild(popup);

      window.scrollTo(0, scrollTop);

      document.removeEventListener('keydown', escClose);
    }

    // Close popup
    close.addEventListener('click', closeWizard);

    function escClose(e) {
      if (e.key == 'Escape') {
        closeWizard();
      }
    }

    document.addEventListener('keydown', escClose);

    const screen = document.createElement('div');
    screen.classList.add('wizard__screen');
    popup.appendChild(screen);

    const recent = getRecent();

    if (recent === null) {
      return createWelcome(screen);
    }

    createFinal(screen, recent);

    // Show warn message if recently used
    const repeated = document.createElement('div');
    repeated.classList.add('wizard__repeated');
    repeated.textContent = knife_custom_wizard.repeated;
    screen.appendChild(repeated);
  }

  /**
   * Get final message based on user choice
   */
  function getMessage(options, callback) {
    const request = new XMLHttpRequest();
    request.open('POST', knife_custom_wizard.url, true);
    request.setRequestHeader('Content-Type', 'application/json');

    request.addEventListener('load', () => {
      try {
        const response = JSON.parse(request.responseText);

        if (request.status === 200 && response.message) {
          return callback(response.message);
        }
      } catch(err) {
        console.error(err);
      }

      callback(null);
    });

    request.addEventListener('error', () => {
      return callback(null);
    });

    request.send(JSON.stringify({options}));
  }

  /**
   * Draw welcome button element
   */
  function drawWelcomeButton(screen) {
    const button = document.createElement('button');
    button.classList.add('wizard__button', 'wizard__button--welcome');
    button.setAttribute('type', 'button');
    screen.appendChild(button);

    const span = document.createElement('span');
    span.textContent = knife_custom_wizard.welcome.button;
    button.appendChild(span);

    const label = document.createElement('label');
    label.textContent = shuffleList(knife_custom_wizard.welcome.labels, 0);
    button.appendChild(label);

    for (let i = 0; i < 2; i++) {
      const star = document.createElement('i');
      star.classList.add('wizard__icon', 'wizard__icon--star');
      button.appendChild(star);
    }

    return button;
  }

  /**
   * Draw call element
   */
  function drawSelectionCall(screen) {
    const call = document.createElement('h2');
    call.classList.add('wizard__call');
    screen.appendChild(call);

    const span = document.createElement('span');
    span.textContent = knife_custom_wizard.selection.title;
    call.appendChild(span);

    const label = document.createElement('label');
    label.textContent = knife_custom_wizard.selection.label;
    call.append(label);

    return call;
  }

  /**
   * Draw selection button element
   */
  function drawSelectionButton(screen) {
    const button = document.createElement('button');
    button.classList.add('wizard__button', 'wizard__button--selection');
    button.setAttribute('type', 'button');
    button.setAttribute('disabled', 'disabled');
    screen.appendChild(button);

    const span = document.createElement('span');
    span.textContent = knife_custom_wizard.selection.button;
    button.appendChild(span);

    for (let i = 0; i < 2; i++) {
      const star = document.createElement('i');
      star.classList.add('wizard__icon', 'wizard__icon--star');
      button.appendChild(star);
    }

    return button;
  }

  /**
   * Create welcome screen
   */
  function createWelcome(screen) {
    popup.classList.add('wizard--welcome');

    const decor = document.createElement('div');
    decor.classList.add('wizard__decor');
    screen.appendChild(decor);

    const sun = document.createElement('span');
    sun.classList.add('wizard__icon', 'wizard__icon--sun');
    decor.appendChild(sun);

    const excerpts = knife_custom_wizard.welcome.excerpts;

    excerpts.forEach(excerpt => {
      const p = document.createElement('h5');
      p.classList.add('wizard__excerpt');
      p.textContent = excerpt;
      screen.appendChild(p);
    });

    const button = drawWelcomeButton(screen);

    button.addEventListener('click', () => {
      popup.classList.remove('wizard--welcome');

      // Load next screen
      loadSelection(screen);
    });
  }

  /**
   * Create final screen
   */
  function createFinal(screen, message) {
    popup.classList.add('wizard--final');

    while (screen.firstChild) {
      screen.removeChild(screen.lastChild);
    }

    const caption = document.createElement('h2');
    caption.classList.add('wizard__caption');
    caption.textContent = message.title;
    screen.appendChild(caption);

    const result = document.createElement('figure');
    result.classList.add('wizard__result');
    result.innerHTML = message.text;
    screen.appendChild(result);

    const decor = document.createElement('div');
    decor.classList.add('wizard__decor', 'wizard__decor--final');
    screen.appendChild(decor);

    const star = document.createElement('span');
    star.classList.add('wizard__icon', 'wizard__icon--star');
    decor.appendChild(star);

    return screen;
  }

  /**
   * Create error screen
   */
  function createError(screen) {
    popup.classList.add('wizard--final');

    while (screen.firstChild) {
      screen.removeChild(screen.lastChild);
    }

    const caption = document.createElement('h2');
    caption.classList.add('wizard__caption');
    caption.textContent = knife_custom_wizard.error.title;
    screen.appendChild(caption);

    const result = document.createElement('figure');
    result.classList.add('wizard__result', 'wizard__result--error');
    result.textContent = knife_custom_wizard.error.text;
    screen.appendChild(result);

    const decor = document.createElement('div');
    decor.classList.add('wizard__decor', 'wizard__decor--final');
    screen.appendChild(decor);

    const star = document.createElement('span');
    star.classList.add('wizard__icon', 'wizard__icon--star');
    decor.appendChild(star);
  }

  /**
   * Create selection screen
   */
  function createSelection(screen) {
    popup.classList.add('wizard--selection');

    while (screen.firstChild) {
      screen.removeChild(screen.lastChild);
    }

    drawSelectionCall(screen);

    const grid = document.createElement('div');
    grid.classList.add('wizard__grid');
    screen.appendChild(grid);

    const button = drawSelectionButton(screen);

    // Shuffle cards
    let chars = [];

    for (let i = 1; i < 16; i++) {
      chars.push(i.toString(16));
    }

    chars = shuffleList(chars);

    // Stores user selection
    const magic = new Set();

    for (let i = 0; i < chars.length; i++) {
      const card = document.createElement('button');
      card.classList.add('wizard__card');
      card.setAttribute('type', 'button');
      card.setAttribute('data-char', chars[i]);
      card.innerHTML = `<i class="wizard__icon wizard__icon--${chars[i]}"></i>`;
      grid.appendChild(card);

      card.addEventListener('click', () => {
        card.classList.remove('wizard__card--active');
        grid.classList.remove('wizard__grid--full');

        button.setAttribute('disabled', 'disabled');

        if (magic.has(card.dataset.char)) {
          return magic.delete(card.dataset.char);
        }

        if (magic.size >= 4) {
          grid.classList.add('wizard__grid--full');
          return button.removeAttribute('disabled');
        }

        magic.add(card.dataset.char);
        card.classList.add('wizard__card--active');

        if (magic.size >= 4) {
          grid.classList.add('wizard__grid--full');
          return button.removeAttribute('disabled');
        }
      });
    }

    button.addEventListener('click', () => {
      popup.classList.remove('wizard--selection');

      // Load next screen
      loadFinal(screen, Array.from(magic).join(''));
    });
  }

  /**
   * Flash card funciton
   */
  function flashCard(cards, cur) {
    if (!popup.classList.contains('wizard--mystery')) {
      return false;
    }

    cards.forEach(card => {
      card.classList.add('wizard__card--flash');
    });

    cards[cur].classList.remove('wizard__card--flash');

    setTimeout(() => {
      let rand = cur;

      while (rand == cur) {
        rand = Math.floor(Math.random() * cards.length);
      }

      return flashCard(cards, rand);
    }, 500);
  }

  /**
   * Load final screen
   */
  function loadFinal(screen, options) {
    popup.classList.add('wizard--mystery');

    setTimeout(() => {
      flashCard(screen.querySelectorAll('.wizard__card--active'), 0);
    }, 750);

    const prepareFinal = (message) => {
      popup.classList.remove('wizard--mystery');

      if (message === null) {
        return createError(screen);
      }

      const storage = {
        timestamp: Math.floor(Date.now() / 1000),
        message: message
      }

      window.localStorage.setItem('secret-wizard', JSON.stringify(storage));

      // Show final screen
      createFinal(screen, message);
    }

    getMessage(options, (message) => {
      setTimeout(() => prepareFinal(message), 2500);
    });
  }

  /**
   * Load selection screen
   */
  function loadSelection(screen) {
    popup.classList.add('wizard--prepare');

    setTimeout(() => {
      popup.classList.remove('wizard--prepare');

      // Create new screen
      createSelection(screen);
    }, 1000);
  }

  let start = 0;

  logo.addEventListener('click', (e) => {
    e.preventDefault();

    if (++start < 3) {
      return window.scrollTo({top: 0, behavior: 'smooth'});
    }

    start = 0;
    showPopup();
  });
})();