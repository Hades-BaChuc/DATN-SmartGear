// Nút scroll hàng ngang
document.querySelectorAll('.scroll-btn').forEach(btn=>{
    btn.addEventListener('click', e=>{
        const target = document.querySelector(btn.dataset.target);
        if(!target) return;
        const dir = Number(btn.dataset.dir || 1);
        target.scrollBy({ left: dir * 600, behavior: 'smooth' });
    });
});
document.querySelectorAll('.category-dropdown').forEach(dd => {
    const btn = dd.querySelector('[data-bs-toggle="dropdown"]');
    const menu = dd.querySelector('.dropdown-menu');
    if (!btn || !menu) return;
    const bsDropdown = new bootstrap.Dropdown(btn, { autoClose: 'outside', display: 'static' });
    const enter = () => window.matchMedia('(min-width: 768px)').matches && bsDropdown.show();
    const leave = () => window.matchMedia('(min-width: 768px)').matches && bsDropdown.hide();
    dd.addEventListener('mouseenter', enter);
    dd.addEventListener('mouseleave', leave);
});
