/**
 * Kios Lilo POS - Kasir Module
 * Handles product display, cart management, and checkout
 */

// Dummy product data (nanti diganti dari database)
const products = [
    { id: 1, name: 'Indomie Goreng', price: 3500, stock: 120, category: 'makanan', emoji: '🍜' },
    { id: 2, name: 'Indomie Kuah', price: 3500, stock: 95, category: 'makanan', emoji: '🍜' },
    { id: 3, name: 'Mie Sedaap', price: 3200, stock: 80, category: 'makanan', emoji: '🍜' },
    { id: 4, name: 'Aqua 600ml', price: 4000, stock: 200, category: 'minuman', emoji: '💧' },
    { id: 5, name: 'Aqua 1500ml', price: 8000, stock: 50, category: 'minuman', emoji: '💧' },
    { id: 6, name: 'Teh Botol Sosro', price: 5000, stock: 75, category: 'minuman', emoji: '🧃' },
    { id: 7, name: 'Coca Cola 390ml', price: 7000, stock: 40, category: 'minuman', emoji: '🥤' },
    { id: 8, name: 'Sprite 390ml', price: 7000, stock: 35, category: 'minuman', emoji: '🥤' },
    { id: 9, name: 'Kopi ABC Sachet', price: 2000, stock: 150, category: 'minuman', emoji: '☕' },
    { id: 10, name: 'Chitato 68g', price: 10000, stock: 30, category: 'snack', emoji: '🍿' },
    { id: 11, name: 'Taro Net', price: 5000, stock: 45, category: 'snack', emoji: '🍿' },
    { id: 12, name: 'Oreo 133g', price: 8500, stock: 25, category: 'snack', emoji: '🍪' },
    { id: 13, name: 'Roti Sari Roti', price: 6000, stock: 20, category: 'makanan', emoji: '🍞' },
    { id: 14, name: 'Telur 1kg', price: 28000, stock: 15, category: 'kebutuhan', emoji: '🥚' },
    { id: 15, name: 'Gula 1kg', price: 16000, stock: 30, category: 'kebutuhan', emoji: '🧂' },
    { id: 16, name: 'Minyak Goreng 1L', price: 18000, stock: 25, category: 'kebutuhan', emoji: '🫗' },
    { id: 17, name: 'Sabun Lifebuoy', price: 4000, stock: 40, category: 'kebutuhan', emoji: '🧴' },
    { id: 18, name: 'Sampoerna Mild 16', price: 32000, stock: 20, category: 'rokok', emoji: '🚬' },
    { id: 19, name: 'Gudang Garam 12', price: 24000, stock: 18, category: 'rokok', emoji: '🚬' },
    { id: 20, name: 'Surya Pro Mild 16', price: 28000, stock: 22, category: 'rokok', emoji: '🚬' },
];

let cart = [];
let activeCategory = 'all';

document.addEventListener('DOMContentLoaded', function () {
    renderProducts(products);
    setupCategoryFilter();
    setupSearch();
    setupPayment();
    setupCheckout();
    setupClearCart();
});

// ---- Render Products ----
function renderProducts(items) {
    const grid = document.getElementById('productGrid');
    if (!grid) return;

    if (items.length === 0) {
        grid.innerHTML = '<div class="cart-empty"><i class="bi bi-search"></i><p>Produk tidak ditemukan</p></div>';
        return;
    }

    grid.innerHTML = items.map(function (p) {
        var stockClass = p.stock <= 10 ? 'low' : '';
        var stockText = p.stock <= 10 ? 'Stok: ' + p.stock + ' (Menipis!)' : 'Stok: ' + p.stock;
        return '<div class="product-card" onclick="addToCart(' + p.id + ')">' +
            '<span class="product-emoji">' + p.emoji + '</span>' +
            '<div class="product-name" title="' + p.name + '">' + p.name + '</div>' +
            '<div class="product-price">' + formatRupiah(p.price) + '</div>' +
            '<div class="product-stock ' + stockClass + '">' + stockText + '</div>' +
            '</div>';
    }).join('');
}

// ---- Category Filter ----
function setupCategoryFilter() {
    var buttons = document.querySelectorAll('.cat-btn');
    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            buttons.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            activeCategory = btn.dataset.cat;
            filterProducts();
        });
    });
}

// ---- Search ----
function setupSearch() {
    var input = document.getElementById('productSearch');
    if (!input) return;
    input.addEventListener('input', function () {
        filterProducts();
    });
}

function filterProducts() {
    var search = document.getElementById('productSearch').value.toLowerCase();
    var filtered = products.filter(function (p) {
        var matchCat = activeCategory === 'all' || p.category === activeCategory;
        var matchSearch = p.name.toLowerCase().includes(search);
        return matchCat && matchSearch;
    });
    renderProducts(filtered);
}

// ---- Add to Cart ----
function addToCart(productId) {
    var product = products.find(function (p) { return p.id === productId; });
    if (!product) return;

    var existing = cart.find(function (item) { return item.id === productId; });
    if (existing) {
        if (existing.qty >= product.stock) {
            alert('Stok tidak mencukupi!');
            return;
        }
        existing.qty++;
    } else {
        cart.push({ id: product.id, name: product.name, price: product.price, qty: 1, emoji: product.emoji });
    }

    renderCart();
    updateTotal();
}

// ---- Render Cart ----
function renderCart() {
    var container = document.getElementById('cartItems');
    var emptyMsg = document.getElementById('cartEmpty');

    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty" id="cartEmpty"><i class="bi bi-cart-x"></i><p>Keranjang kosong</p><span>Klik produk untuk menambahkan</span></div>';
        return;
    }

    container.innerHTML = cart.map(function (item) {
        var subtotal = item.price * item.qty;
        return '<div class="cart-item">' +
            '<span style="font-size:1.5rem">' + item.emoji + '</span>' +
            '<div class="cart-item-info">' +
                '<div class="cart-item-name">' + item.name + '</div>' +
                '<div class="cart-item-price">' + formatRupiah(item.price) + '</div>' +
            '</div>' +
            '<div class="cart-item-qty">' +
                '<button class="qty-btn minus" onclick="changeQty(' + item.id + ',-1)"><i class="bi bi-dash"></i></button>' +
                '<span class="qty-value">' + item.qty + '</span>' +
                '<button class="qty-btn" onclick="changeQty(' + item.id + ',1)"><i class="bi bi-plus"></i></button>' +
            '</div>' +
            '<div class="cart-item-subtotal">' + formatRupiah(subtotal) + '</div>' +
            '<button class="cart-item-remove" onclick="removeFromCart(' + item.id + ')"><i class="bi bi-x-lg"></i></button>' +
            '</div>';
    }).join('');
}

// ---- Change Quantity ----
function changeQty(productId, delta) {
    var item = cart.find(function (i) { return i.id === productId; });
    if (!item) return;

    var product = products.find(function (p) { return p.id === productId; });
    var newQty = item.qty + delta;

    if (newQty <= 0) {
        removeFromCart(productId);
        return;
    }
    if (product && newQty > product.stock) {
        alert('Stok tidak mencukupi!');
        return;
    }

    item.qty = newQty;
    renderCart();
    updateTotal();
}

// ---- Remove from Cart ----
function removeFromCart(productId) {
    cart = cart.filter(function (i) { return i.id !== productId; });
    renderCart();
    updateTotal();
}

// ---- Update Total ----
function updateTotal() {
    var total = cart.reduce(function (sum, item) { return sum + (item.price * item.qty); }, 0);
    document.getElementById('subtotal').textContent = formatRupiah(total);
    document.getElementById('grandTotal').textContent = formatRupiah(total);

    var payInput = document.getElementById('paymentAmount');
    var payment = parseInt(payInput.value) || 0;
    var change = payment - total;

    var changeEl = document.getElementById('changeAmount');
    changeEl.textContent = change >= 0 ? formatRupiah(change) : '-' + formatRupiah(Math.abs(change));
    changeEl.style.color = change >= 0 ? 'var(--success)' : 'var(--danger)';

    var checkoutBtn = document.getElementById('checkoutBtn');
    checkoutBtn.disabled = cart.length === 0 || payment < total;
}

// ---- Payment Input ----
function setupPayment() {
    var input = document.getElementById('paymentAmount');
    if (!input) return;
    input.addEventListener('input', updateTotal);
}

// ---- Clear Cart ----
function setupClearCart() {
    var btn = document.getElementById('clearCart');
    if (!btn) return;
    btn.addEventListener('click', function () {
        if (cart.length === 0) return;
        if (confirm('Hapus semua item di keranjang?')) {
            cart = [];
            renderCart();
            updateTotal();
            document.getElementById('paymentAmount').value = '';
        }
    });
}

// ---- Checkout ----
function setupCheckout() {
    var btn = document.getElementById('checkoutBtn');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var total = cart.reduce(function (sum, item) { return sum + (item.price * item.qty); }, 0);
        var payment = parseInt(document.getElementById('paymentAmount').value) || 0;
        var change = payment - total;

        if (payment < total) { alert('Pembayaran kurang!'); return; }

        // Show success modal
        document.getElementById('modalInfo').textContent =
            'Total: ' + formatRupiah(total) + ' | Bayar: ' + formatRupiah(payment) + ' | Kembali: ' + formatRupiah(change);
        document.getElementById('successModal').classList.add('show');
    });

    // New Transaction
    var newBtn = document.getElementById('newTransaction');
    if (newBtn) {
        newBtn.addEventListener('click', function () {
            cart = [];
            renderCart();
            updateTotal();
            document.getElementById('paymentAmount').value = '';
            document.getElementById('successModal').classList.remove('show');
        });
    }

    // Print Receipt
    var printBtn = document.getElementById('printReceipt');
    if (printBtn) {
        printBtn.addEventListener('click', function () {
            var total = cart.reduce(function (s, i) { return s + (i.price * i.qty); }, 0);
            var payment = parseInt(document.getElementById('paymentAmount').value) || 0;
            var change = payment - total;
            var now = new Date();
            var trxId = 'TRX-' + now.getFullYear() +
                String(now.getMonth()+1).padStart(2,'0') +
                String(now.getDate()).padStart(2,'0') + '-' +
                String(now.getHours()).padStart(2,'0') +
                String(now.getMinutes()).padStart(2,'0') +
                String(now.getSeconds()).padStart(2,'0');
            var dateStr = now.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
            var timeStr = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

            var rows = cart.map(function (item) {
                var sub = item.price * item.qty;
                return '<tr>' +
                    '<td style="padding:4px 0">' + item.name + '</td>' +
                    '<td style="text-align:center;padding:4px 0">' + item.qty + '</td>' +
                    '<td style="text-align:right;padding:4px 0">' + formatRupiah(item.price) + '</td>' +
                    '<td style="text-align:right;padding:4px 0">' + formatRupiah(sub) + '</td>' +
                    '</tr>';
            }).join('');

            var receiptHTML = '<!DOCTYPE html><html><head><title>Struk ' + trxId + '</title>' +
                '<style>' +
                'body{font-family:monospace;font-size:12px;width:280px;margin:0 auto;padding:10px;color:#000}' +
                '.center{text-align:center}' +
                '.bold{font-weight:bold}' +
                '.line{border-top:1px dashed #000;margin:8px 0}' +
                'table{width:100%;border-collapse:collapse}' +
                'th{text-align:left;padding:4px 0;border-bottom:1px solid #000;font-size:11px}' +
                '.right{text-align:right}' +
                '.summary td{padding:3px 0}' +
                '@media print{body{margin:0;padding:5px}}' +
                '</style></head><body>' +
                '<div class="center bold" style="font-size:16px">PERLENGKAPAN BASO</div>' +
                '<div class="center" style="font-size:11px">Jl. Contoh No. 123, Kota</div>' +
                '<div class="center" style="font-size:11px">Telp: 0812-3456-7890</div>' +
                '<div class="line"></div>' +
                '<div style="font-size:11px">No: ' + trxId + '</div>' +
                '<div style="font-size:11px">Tanggal: ' + dateStr + '</div>' +
                '<div style="font-size:11px">Waktu: ' + timeStr + '</div>' +
                '<div style="font-size:11px">Kasir: Admin</div>' +
                '<div class="line"></div>' +
                '<table><thead><tr>' +
                '<th>Item</th><th style="text-align:center">Qty</th><th style="text-align:right">Harga</th><th style="text-align:right">Subtotal</th>' +
                '</tr></thead><tbody>' + rows + '</tbody></table>' +
                '<div class="line"></div>' +
                '<table class="summary">' +
                '<tr><td class="bold">TOTAL</td><td class="right bold" style="font-size:14px">' + formatRupiah(total) + '</td></tr>' +
                '<tr><td>Bayar</td><td class="right">' + formatRupiah(payment) + '</td></tr>' +
                '<tr><td>Kembali</td><td class="right">' + formatRupiah(change) + '</td></tr>' +
                '</table>' +
                '<div class="line"></div>' +
                '<div class="center" style="font-size:11px">Terima kasih telah berbelanja!</div>' +
                '<div class="center" style="font-size:10px;margin-top:4px">~ Perlengkapan Baso POS ~</div>' +
                '<script>window.onload=function(){window.print();}<\/script>' +
                '</body></html>';

            var printWindow = window.open('', '_blank', 'width=350,height=600');
            printWindow.document.write(receiptHTML);
            printWindow.document.close();
        });
    }
}

// ---- Format Rupiah ----
function formatRupiah(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}
