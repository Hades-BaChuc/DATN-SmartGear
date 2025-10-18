import './bootstrap';
(() => {
  // Qty stepper (cart & detail)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-step]');
    if (!btn) return;
    const wrap = btn.closest('[data-qty-wrap]');
    const input = wrap?.querySelector('input[type="number"]');
    if (!input) return;

    const step = btn.dataset.step === 'inc' ? 1 : -1;
    const min = parseInt(input.min || 1, 10);
    const max = parseInt(input.max || 999, 10);
    const next = Math.min(Math.max((parseInt(input.value || 1, 10) + step), min), max);
    input.value = next;
    input.dispatchEvent(new Event('change'));
  });

  // Navbar shadow on scroll
  const nav = document.querySelector('nav.navbar');
  const onScroll = () => nav && nav.classList.toggle('scrolled', window.scrollY > 2);
  onScroll(); window.addEventListener('scroll', onScroll);

  // Mega menu: hover/click đổi panel
  const mega = document.querySelector('.dropdown-mega');
  if (mega) {
    const items  = mega.querySelectorAll('.mega-left .mega-item');
    const panels = mega.querySelectorAll('.mega-right .mega-panel');

    const activate = (id) => {
      const norm = id.startsWith('#') ? id.slice(1) : id;
      items.forEach(i => i.classList.toggle('active', i.dataset.target.replace('#','') === norm));
      panels.forEach(p => p.classList.toggle('show', p.id === norm));
    };

    items.forEach(it => {
      it.addEventListener('mouseenter', () => activate(it.dataset.target));   // hover desktop
      it.addEventListener('click', (e) => { e.preventDefault(); activate(it.dataset.target); });
    });
  }

  // --- CART total calculator ---
function formatVND(n){ return (n||0).toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.') + 'đ'; }

function recalcCart(){
  const items = document.querySelectorAll('.cart-item');
  let subtotal = 0;
  items.forEach(row => {
    const price = parseInt(row.dataset.price,10) || 0;
    const qty   = parseInt(row.querySelector('input[type="number"]').value,10) || 1;
    const line  = price * qty;
    row.querySelector('.line-total').textContent = formatVND(line);
    subtotal += line;
  });
  const elSubtotal = document.getElementById('subtotal');
  const elGrand    = document.getElementById('grand');
  if(elSubtotal) elSubtotal.textContent = formatVND(subtotal);
  if(elGrand)    elGrand.textContent    = formatVND(subtotal); // chưa áp mã/ship
}

document.addEventListener('change', (e)=>{
  if (e.target.matches('.cart-item input[type="number"]')) recalcCart();
});
document.addEventListener('click', (e)=>{
  const btnRemove = e.target.closest('[data-remove]');
  if(btnRemove){
    btnRemove.closest('.cart-item')?.remove();
    recalcCart();
  }
});
window.addEventListener('DOMContentLoaded', recalcCart);

})();


document.addEventListener('click', e=>{
    if(e.target.matches('.qty-stepper .btn-inc, .qty-stepper .btn-dec')){
        const input = e.target.closest('.qty-stepper').querySelector('input[type="number"]');
        const min = parseInt(input.min || '1', 10);
        let val = parseInt(input.value || '1', 10);
        val += e.target.matches('.btn-inc') ? 1 : -1;
        if(val < min) val = min;
        input.value = val;
        input.dispatchEvent(new Event('change'));
    }
});
