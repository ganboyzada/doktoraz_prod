(function () {
  const pre = document.getElementById('site-preloader');
  if (!pre) return;

  const show = () => {
    pre.classList.remove('preloader-hidden');
    pre.style.display = 'flex';
    void pre.offsetHeight; // force paint immediately
  };

  const hide = () => {
    setTimeout(() => {
      pre.classList.add('preloader-hidden');
    }, 200);
  };

  window.addEventListener('load', hide);

  document.addEventListener('click', e => {
    const a = e.target.closest('a');
    if (!a) return;
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') || a.target === '_blank') return;
    if (a.origin === location.origin) {
      e.preventDefault();
      show();
      requestAnimationFrame(() => requestAnimationFrame(() => location.href = href));
    }
  });

  window.addEventListener('pageshow', () => pre.classList.add('preloader-hidden'));
  setTimeout(() => pre.classList.add('preloader-hidden'), 8000);
})();
