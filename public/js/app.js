document.addEventListener('click', function(e){
    const tab = e.target.closest('.tab');
    if(tab && tab.dataset.tab){
        const tabsContainer = tab.parentElement;
        tabsContainer.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const panel = tabsContainer.parentElement;
        panel.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        const target = document.getElementById('tab-' + tab.dataset.tab);
        if(target) target.classList.add('active');
    }
    const faqQ = e.target.closest('.faq-q');
    if(faqQ) faqQ.parentElement.classList.toggle('open');
});

function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge();
    if (document.getElementById('cartLayout')) {
        renderCartPage(); 
    }
}

function updateCartBadge(){
    const cart = getCart();
    const n = cart.reduce((s,i) => s + i.qty, 0);
    const el = document.getElementById('cartCount');
    if(el) el.textContent = toFa(n);
}

function addToCart(id){
    if (!window.userLoggedIn) {
        window.location.href = '/login';
        return;
    }
    let cart = getCart();
    const item = cart.find(i => i.id === id);
    if(item) item.qty++;
    else cart.push({id, qty:1});
    saveCart(cart);
    toast('به سبد خرید اضافه شد ✅');
}

function removeFromCart(id) {
    let cart = getCart();
    cart = cart.filter(i => i.id !== id);
    saveCart(cart);
    toast('از سبد خرید حذف شد', 'warn');
}

function updateQty(id, delta) {
    let cart = getCart();
    const item = cart.find(i => i.id === id);
    if (!item) return;
    
    item.qty += delta;
    if (item.qty <= 0) {
        removeFromCart(id);
        return;
    }
    saveCart(cart);
}

function toggleWishlist(id){
    if (!window.userLoggedIn) {
        window.location.href = '/login';
        return;
    }
    let w = JSON.parse(localStorage.getItem('wish') || '[]');
    const i = w.indexOf(id);
    if(i >= 0){ w.splice(i,1); toast('حذف شد', 'warn'); }
    else { w.push(id); toast('اضافه شد ❤️'); }
    localStorage.setItem('wish', JSON.stringify(w));
}

function renderCartPage() {
    const cart = getCart();
    const container = document.getElementById('cartItemsContainer');
    const layout = document.getElementById('cartLayout');
    const empty = document.getElementById('emptyCart');
    const subtitle = document.getElementById('cartSubtitle');

    if (!container) return;

    if (cart.length === 0) {
        layout.style.display = 'none';
        empty.style.display = 'block';
        subtitle.textContent = 'سبد شما خالی است';
        return;
    }

    layout.style.display = 'grid';
    empty.style.display = 'none';
    subtitle.textContent = cart.length + ' عنوان کتاب در سبد شما';

    let html = '';
    let total = 0;

    cart.forEach(item => {
        const book = window.allBooks.find(b => b.id === item.id);
        if (!book) return;

        const bookTotal = book.price * item.qty;
        total += bookTotal;

        let bg = book.cover ? `url('${book.cover}') center/cover` : 'var(--grad-fresh)';
        let titleShort = book.title.length > 8 ? book.title.substring(0, 8) + '...' : book.title;

        html += `
            <div class="cart-item">
                <div class="cart-item-cover" style="background: ${bg}">
                    ${!book.cover ? titleShort : ''}
                </div>
                <div class="cart-item-info">
                    <div class="t">${book.title}</div>
                    <div class="a">${book.author_name}</div>
                </div>
                <div class="qty">
                    <button onclick="updateQty('${book.id}', -1)">−</button>
                    <span>${toFa(item.qty)}</span>
                    <button onclick="updateQty('${book.id}', 1)">+</button>
                </div>
                <div class="price" style="font-family:var(--font-title);color:var(--mint-d)">
                    ${toFa(bookTotal.toLocaleString('en-US'))} <small>ت</small>
                </div>
                <button class="icon-btn" onclick="removeFromCart('${book.id}')" style="width:36px;height:36px;color:var(--coral)">🗑️</button>
            </div>
        `;
    });

    container.innerHTML = html;
    
    document.getElementById('cartTotal').textContent = toFa(total.toLocaleString('en-US')) + ' تومان';
    const finalTotal = total > 0 ? total + 45000 : 0;
    document.getElementById('finalTotal').textContent = toFa(finalTotal.toLocaleString('en-US')) + ' تومان';
}

// =============== ابزارها ===============
function toast(msg, type = 'success'){
    const wrap = document.getElementById('toastWrap');
    if(!wrap) return;
    const t = document.createElement('div');
    t.className = 'toast ' + type;
    t.innerHTML = `<span>${type === 'success' ? '✅' : '⚠️'}</span><span>${msg}</span>`;
    wrap.appendChild(t);
    setTimeout(() => {
        t.style.opacity = '0';
        t.style.transform = 'translateX(-100px)';
        setTimeout(() => t.remove(), 300);
    }, 2600);
}

function toFa(n){
    return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartBadge();
    renderCartPage();
});