require('./bootstrap');

import '../scss/app.scss';

import { Modal, Toast, Popover } from 'bootstrap'

// import logo from '../images/logo.png';
// import macronImg from '../images/macron.jpg';
// import hollandeImg from '../images/hollande.jpg';
// import sarkozyImg from '../images/sarkozy.jpg';
// import chiracImg from '../images/chirac.jpg';
// import mitterrandImg from '../images/mitterrand.jpg';

// document.querySelector('.navbar-brand img').src = logo;
// document.querySelector('img[alt="Emmanuel Macron"]').src = macronImg;
// document.querySelector('img[alt="François Hollande"]').src = hollandeImg;
// document.querySelector('img[alt="Nicolas Sarkozy"]').src = sarkozyImg;
// document.querySelector('img[alt="Jacques Chirac"]').src = chiracImg;
// document.querySelector('img[alt="François Mitterrand"]').src = mitterrandImg;


document.addEventListener('DOMContentLoaded', () => {
  const loadBtn = document.querySelector('#loadBtn');
  const toastEl = document.querySelector('#myToast');

  const toast = new Toast(toastEl, {
    delay: 4000,
  });

  loadBtn.addEventListener('click', () => {
    toast.show();
  });
});


document.addEventListener('DOMContentLoaded', () => {
  const cards = Array.from(document.querySelectorAll('.president-card'));
  const modalElement = document.getElementById('infoModal');
  const modal = new Modal(modalElement);
  const modalDescription = document.getElementById('modalDescription');


  const descriptions = {
    macron: `Эммануэль Макрон проводит политику
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Экономические реформы"
        data-bs-trigger="hover focus"
        data-bs-content="Пакет изменений в налоговой и трудовой системах для стимулирования бизнеса.">
        реформ
      </span>
      и активно продвигает
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Европейская интеграция"
        data-bs-trigger="hover focus"
        data-bs-content="Укрепление роли Франции в Европейском Союзе и развитие совместных инициатив.">
        интеграцию Европы
      </span>.`,
    
    hollande: `Франсуа Олланд сосредоточил внимание на
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Социальная политика"
        data-bs-trigger="hover focus"
        data-bs-content="Меры по поддержке безработных и повышению минимальной заработной платы.">
        социальной политике
      </span>
      и введении
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Налоги для богатых"
        data-bs-trigger="hover focus"
        data-bs-content="Временное повышение налогов для состоятельных граждан.">
        налогов для богатых
      </span>.`,
    
    sarkozy: `Николя Саркози проводил
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Пенсионная реформа"
        data-bs-trigger="hover focus"
        data-bs-content="Увеличение пенсионного возраста с 60 до 62 лет.">
        пенсионную реформу
      </span>
      и вел активную
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Внешняя политика"
        data-bs-trigger="hover focus"
        data-bs-content="Активное участие Франции в международных переговорах и военных миссиях.">
        внешнюю политику
      </span>.`,
    
    chirac: `Жак Ширак выступил против
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Война в Ираке"
        data-bs-trigger="hover focus"
        data-bs-content="Франция отказалась поддержать военную операцию США в 2003 году.">
        войны в Ираке
      </span>
      и поддерживал
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Сельское хозяйство"
        data-bs-trigger="hover focus"
        data-bs-content="Активно отстаивал интересы фермеров и развивал аграрные субсидии.">
        фермеров
      </span>.`,
    
    mitterrand: `Франсуа Миттеран провел масштабную
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Национализация"
        data-bs-trigger="hover focus"
        data-bs-content="Переход крупных предприятий и банков в собственность государства.">
        национализацию
      </span>
      и продвигал
      <span class="text-primary fw-semibold" data-bs-toggle="popover" title="Социальные реформы"
        data-bs-trigger="hover focus"
        data-bs-content="Увеличение социальных гарантий и развитие образования.">
        социальные реформы
      </span>.`
  };

  const presidentOrder = ['macron', 'hollande', 'sarkozy', 'chirac', 'mitterrand'];
  let currentPresidentIndex = 0;

  cards.forEach((card) => {
    card.addEventListener('click', () => {
      const key = card.dataset.president;
      currentPresidentIndex = presidentOrder.indexOf(key);
      showPresidentInfo(key);
    });
  });


  function showPresidentInfo(key) {
    modalDescription.innerHTML = descriptions[key];
    modal.show();

    setTimeout(() => {
      const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
      popovers.forEach(el => new Popover(el));
    }, 200);
  }


  document.addEventListener('keydown', (e) => {
    if (!document.body.classList.contains('modal-open')) return;

    if (e.key === 'ArrowRight') {
      // Следующий президент
      currentPresidentIndex = (currentPresidentIndex + 1) % presidentOrder.length;
      showPresidentInfo(presidentOrder[currentPresidentIndex]);
    }

    if (e.key === 'ArrowLeft') {
      // Предыдущий президент
      currentPresidentIndex = (currentPresidentIndex - 1 + presidentOrder.length) % presidentOrder.length;
      showPresidentInfo(presidentOrder[currentPresidentIndex]);
    }
  });
});


