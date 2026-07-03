/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import mask from '@alpinejs/mask';

Alpine.plugin(persist);
Alpine.plugin(mask);

window.Alpine = Alpine;

/* THEME_TOGGLE_START */
(function () {
	'use strict';
	function applyTheme(preference) {
		var html = document.documentElement;
		var systemDark = window.matchMedia(
			'(prefers-color-scheme: dark)'
		).matches;
		var isDark =
			preference === 'dark' ||
			(preference === 'system' && systemDark);
		html.classList.toggle('dark', isDark);
		html.classList.toggle('light', !isDark);
		html.setAttribute('data-theme', isDark ? 'dark' : 'light');
	}
	var saved = localStorage.getItem('pemu-theme') || 'system';
	applyTheme(saved);
	window
		.matchMedia('(prefers-color-scheme: dark)')
		.addEventListener('change', function () {
			if (
				(localStorage.getItem('pemu-theme') || 'system') ===
				'system'
			) {
				applyTheme('system');
			}
		});
	window.pemuSetTheme = function (preference) {
		localStorage.setItem('pemu-theme', preference);
		applyTheme(preference);
	};
})();
/* THEME_TOGGLE_END */
/* THEME_TOGGLE_END */

(function () {
	if (typeof jQuery !== 'undefined') {
		[
			'added_to_cart',
			'removed_from_cart',
			'wc_fragments_refreshed',
			'wc_fragments_loaded',
			'updated_checkout',
			'checkout_place_order',
			'checkout_error',
			'found_variation',
			'reset_data',
		].forEach(function (e) {
			jQuery(document.body).on(e, function () {
				const t = Array.prototype.slice.call(arguments, 1);
				window.dispatchEvent(new CustomEvent('wc:' + e, { detail: t }));
			});
		});
	}

	let cartTimer;

	document.addEventListener('alpine:init', function () {
		Alpine.store('product', {
			stickyATCVisible: false,
		});

		Alpine.store('cart', {
			count: window.pemuData?.cartCount || 0,
			toastMessage: '',
			toastSubtitle: 'Your cart has been updated.',
			toastType: 'success',
			toastVisible: false,
			animating: false,
			toastTimer: null,
			init() {
				window.addEventListener('wc:wc_fragments_refreshed', () => {
					this.updateCount();
					this.animateBadge();
				});
				window.addEventListener('wc:wc_fragments_loaded', () => {
					this.updateCount();
				});
				window.addEventListener('wc:added_to_cart', (e) => {
					// e.detail[0] = fragments, e.detail[1] = cart_hash
					const fragments = e.detail && e.detail[0];
					if (fragments && window.pemuApplyFragments) {
						window.pemuApplyFragments(fragments);
					}
					this.showToast(
						'Added to cart!',
						'Your cart has been updated.',
						'success'
					);
				});
				window.addEventListener('wc:removed_from_cart', () => {
					this.updateCount();
					this.showToast(
						'Item removed',
						'Your cart has been updated.',
						'success'
					);
				});
			},
			updateCount() {
				const e = document.querySelector('.pemu-cart-count');
				if (e && e.textContent) {
					this.count = parseInt(e.textContent.trim(), 10) || 0;
				}
			},
			showToast(
				message,
				subtitle = 'Your cart has been updated.',
				type = 'success'
			) {
				this.toastMessage = message;
				this.toastSubtitle = subtitle;
				this.toastType = type;
				this.toastVisible = true;
				clearTimeout(this.toastTimer);
				this.toastTimer = setTimeout(() => {
					this.toastVisible = false;
				}, 4000);
			},
			animateBadge() {
				this.animating = true;
				setTimeout(() => {
					this.animating = false;
				}, 300);
			},
		});

		// Explicitly initialize the store since auto-init is finicky on stores
		Alpine.store('cart').init();

		// Helper: read count from fragments returned by WC AJAX
		window.pemuApplyFragments = function (fragments) {
			if (!fragments) return;
			// Find count from the cart-count fragment
			const tempDiv = document.createElement('div');
			Object.entries(fragments).forEach(([selector, html]) => {
				tempDiv.innerHTML = html;
				const countEl = tempDiv.querySelector('.pemu-cart-count');
				if (countEl) {
					const c = parseInt(countEl.textContent.trim(), 10) || 0;
					Alpine.store('cart').count = c;
					Alpine.store('cart').animateBadge();
				}
				// For cart-count badges: DON'T replace via outerHTML
				// — they're Alpine-managed (x-data, x-text, x-show, :class)
				// — outerHTML would destroy Alpine reactivity + lose positioning classes
				// Alpine's $store.cart.count reactivity handles updates automatically
				if (selector === '.pemu-cart-count') return;
				// For other fragments (mini-cart etc.): update DOM
				document
					.querySelectorAll(selector)
					.forEach((el) => (el.outerHTML = html));
			});
		};

		Alpine.data('stickyAtc', function (config) {
			return {
				qty: 1,
				loading: false,
				productId: config.productId || 0,
				productName: config.productName || '',
				add: function () {
					if (this.loading) return;
					this.loading = true;
					var self = this;
					var fd = new FormData();
					fd.append('product_id', self.productId);
					fd.append('quantity', self.qty);
					fetch(window.pemuData.homeUrl + '?wc-ajax=add_to_cart', {
						method: 'POST',
						body: fd,
					})
						.then(function (r) {
							return r.text();
						})
						.then(function (text) {
							self.loading = false;
							window.pemuHandleAddedToCart(
								window.pemuParseWcResponse(text),
								self.qty,
								self.productName,
								null
							);
						})
						.catch(function () {
							self.loading = false;
							window.pemuHandleAddedToCart(
								null,
								self.qty,
								self.productName,
								null
							);
						});
				},
			};
		});

		Alpine.data('pemuGallery', function (config) {
			return {
				activeIndex: config?.activeIndex || 0,
				totalImages: config?.totalImages || 1,
				touchStartX: 0,
				touchStartY: 0,
				init: function () {
					var e = this;
					e.$el.addEventListener('keydown', function (t) {
						if (t.key === 'ArrowLeft') {
							t.preventDefault();
							e.prev();
						}
						if (t.key === 'ArrowRight') {
							t.preventDefault();
							e.next();
						}
					});
					document.addEventListener(
						'wc:found_variation',
						function (t) {
							var n = t.detail[0];
							if (n && n.image_id) {
								e.$el
									.querySelectorAll('[role="listitem"] img')
									.forEach(function (imgEl, index) {
										if (
											parseInt(imgEl.dataset.id, 10) ===
											parseInt(n.image_id, 10)
										) {
											e.goTo(index);
										}
									});
							}
						}
					);
					document.addEventListener('wc:reset_data', function () {
						e.goTo(0);
					});
				},
				next: function () {
					this.totalImages > 1 &&
						this.goTo((this.activeIndex + 1) % this.totalImages);
				},
				prev: function () {
					this.totalImages > 1 &&
						this.goTo(
							(this.activeIndex - 1 + this.totalImages) %
								this.totalImages
						);
				},
				goTo: function (index) {
					if (index !== this.activeIndex) {
						this.activeIndex = index;
						this._syncThumbs();
						document.dispatchEvent(
							new CustomEvent('pemu:gallery_change', {
								detail: { index: index },
							})
						);
					}
				},
				handleSwipe: function (e) {
					var t = e.changedTouches[0].clientX - this.touchStartX;
					var n = e.changedTouches[0].clientY - this.touchStartY;
					if (Math.abs(t) > 40 && Math.abs(t) > 1.2 * Math.abs(n)) {
						t < 0 ? this.next() : this.prev();
					}
				},
				_syncThumbs: function () {
					this.$el
						.querySelectorAll('.flex-control-thumbs img')
						.forEach((img, index) => {
							img.classList.toggle(
								'flex-active',
								index === this.activeIndex
							);
						});
				},
			};
		});

		Alpine.data('qtyInput', function (config) {
			return {
				value: config.value || 1,
				min: config.min || 0,
				max: config.max || '',
				step: config.step || 1,
				increment() {
					if (this.max && this.value >= this.max) return;
					this.value += this.step;
					this.triggerChange();
				},
				decrement() {
					if (this.value <= this.min) return;
					this.value -= this.step;
					this.triggerChange();
				},
				triggerChange() {
					this.$nextTick(() => {
						this.$refs.input.dispatchEvent(
							new Event('change', { bubbles: true })
						);
					});
				},
			};
		});

		Alpine.data('shopFilters', function () {
			return {
				loading: false,
				applyFilter: function (e, t, n) {
					var a = new URL(window.location.href);
					if (n) {
						a.searchParams.delete('min_price');
						a.searchParams.delete('max_price');
						a.searchParams.delete('product_cat');
						a.searchParams.delete('orderby');
						a.searchParams.delete('paged');
					}
					t ? a.searchParams.set(e, t) : a.searchParams.delete(e);
					a.searchParams.delete('paged');
					this._load(a.toString());
				},
				clearAll: function () {
					var e =
						window.pemuData?.shopUrl || window.location.pathname;
					this._load(e);
				},
				_load: function (e) {
					this.loading = true;
					history.pushState({}, '', e);
					window.location.href = e;
				},
			};
		});

		Alpine.data('orderbySelect', function () {
			return {
				value: '',
				change: function () {
					var e = new URL(window.location.href);
					e.searchParams.set('orderby', this.value);
					e.searchParams.delete('paged');
					window.location.href = e.toString();
				},
			};
		});

		Alpine.data('shippingMethods', function () {
			return {
				init: function () {
					this._styleMethods();
				},
				_styleMethods: function () {
					var e = this;
					setTimeout(function () {
						e.$el
							.querySelectorAll('#shipping_method li')
							.forEach(function (li) {
								var t = li.querySelector('input[type="radio"]');
								var n = li.querySelector('label');
								if (t && n) {
									var a = t.checked;
									li.classList.add(
										'flex',
										'items-center',
										'gap-3',
										'p-4',
										'rounded-xl',
										'border-2',
										'cursor-pointer',
										'transition-all',
										'duration-150'
									);
									li.classList.toggle(
										'border-brand-green',
										a
									);
									li.classList.toggle('bg-brand-green/5', a);
									li.classList.toggle('border-slate-200', !a);
									li.classList.toggle(
										'hover:border-brand-green/50',
										!a
									);
									n.classList.add('flex-1', 'cursor-pointer');
									t.classList.add(
										'text-brand-green',
										'focus:ring-brand-green',
										'focus:ring-offset-0'
									);
								}
							});
					}, 50);
				},
			};
		});

		Alpine.data('paymentMethods', function () {
			return {
				init: function () {
					this._styleMethods();
				},
				_styleMethods: function () {
					var e = this;
					setTimeout(function () {
						e.$el
							.querySelectorAll('.wc_payment_method')
							.forEach(function (li) {
								var t = li.querySelector('label');
								var n = li.querySelector('input[type="radio"]');
								if (t) {
									var a = !!n && n.checked;
									t.classList.add(
										'flex',
										'items-center',
										'gap-3',
										'p-4',
										'rounded-xl',
										'border-2',
										'cursor-pointer',
										'transition-all',
										'duration-150',
										'block'
									);
									t.classList.toggle('border-brand-green', a);
									t.classList.toggle('bg-brand-green/5', a);
									t.classList.toggle('border-slate-200', !a);
								}
							});
					}, 50);
				},
			};
		});

		Alpine.data('placeOrderBtn', function () {
			return {
				loading: false,
				init: function () {
					var e = this;
					document.addEventListener(
						'wc:checkout_place_order',
						function () {
							e.loading = true;
						}
					);
					document.addEventListener('wc:checkout_error', function () {
						e.loading = false;
					});
				},
			};
		});

		Alpine.data('checkoutScroll', function () {
			return {
				init: function () {
					document.addEventListener('wc:checkout_error', function () {
						setTimeout(function () {
							var e = document.querySelector(
								'.woocommerce-invalid input'
							);
							if (e)
								e.scrollIntoView({
									behavior: 'smooth',
									block: 'center',
								});
						}, 150);
					});
				},
			};
		});
	});

	// ── Helper: robust JSON extraction from WP response text ──
	window.pemuParseWcResponse = function pemuParseWcResponse(text) {
		let data = null;
		try {
			data = JSON.parse(text);
			return data;
		} catch (ex) {}
		try {
			const m = text.match(/(\{[\s\S]*\})\s*$/);
			if (m) data = JSON.parse(m[1]);
		} catch (ex) {}
		return data;
	};

	// ── Helper: handle successful WC add-to-cart response ──
	window.pemuHandleAddedToCart = function pemuHandleAddedToCart(
		data,
		qty,
		productName,
		triggerEl
	) {
		const name = productName || 'Item';
		if (data && data.error && data.product_url) {
			window.location = data.product_url;
			return;
		}
		// Update cart count
		if (data && data.fragments) {
			window.pemuApplyFragments &&
				window.pemuApplyFragments(data.fragments);
		} else if (window.Alpine) {
			Alpine.store('cart').count =
				(Alpine.store('cart').count || 0) + parseInt(qty, 10);
			Alpine.store('cart').animateBadge();
		}
		if (window.Alpine)
			Alpine.store('cart').showToast(
				name + ' added to cart!',
				'Your cart has been updated.',
				'success'
			);
		if (typeof jQuery !== 'undefined') {
			jQuery(document.body).trigger('wc_fragment_refresh');
			if (data)
				jQuery(document.body).trigger('added_to_cart', [
					data.fragments,
					data.cart_hash,
					triggerEl,
				]);
		}
	};

	// ── AJAX Add to Cart: shop/home + buttons ──
	document.addEventListener('click', function (e) {
		const t = e.target.closest('.ajax_add_to_cart');
		if (!t) return;
		e.preventDefault();
		const n = t.dataset.product_id;
		const a = t.dataset.quantity || 1;
		if (!n) return;

		// Extract product name from aria-label: "Add {name} to cart"
		const ariaLabel = t.getAttribute('aria-label') || '';
		const nameMatch = ariaLabel.match(/^Add (.+?) to cart$/i);
		const productName = nameMatch
			? nameMatch[1]
			: t
					.closest('li')
					?.querySelector(
						'.woocommerce-loop-product__title, h2 a, .wp-block-post-title'
					)
					?.textContent?.trim() || '';

		t.classList.add('loading');
		const o = t.innerHTML;
		t.innerHTML =
			'<svg class="animate-spin w-4 h-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

		const r = new FormData();
		r.append('product_id', n);
		r.append('quantity', a);

		fetch(window.pemuData.homeUrl + '?wc-ajax=add_to_cart', {
			method: 'POST',
			body: r,
		})
			.then((res) => res.text())
			.then((text) => {
				t.innerHTML = o;
				t.classList.remove('loading');
				pemuHandleAddedToCart(
					pemuParseWcResponse(text),
					a,
					productName,
					t
				);
			})
			.catch(() => {
				t.innerHTML = o;
				t.classList.remove('loading');
				pemuHandleAddedToCart(null, a, productName, t);
			});
	});

	// ── AJAX Add to Cart: single product form ──
	document.addEventListener('submit', function (e) {
		const form = e.target;
		if (!form.classList.contains('cart')) return;
		const submitBtn = form.querySelector(
			'button[name="add-to-cart"], input[name="add-to-cart"]'
		);
		if (!submitBtn) return;
		// Skip variable products — they need native form submit for variation selection
		if (
			form.classList.contains('variations_form') ||
			form.querySelector('table.variations')
		)
			return;

		e.preventDefault();

		const productId = submitBtn.value || submitBtn.dataset.product_id;
		if (!productId) return;

		const qtyInput = form.querySelector('input[name="quantity"]');
		const qty = qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;

		// Get product name from page heading
		const titleEl = document.querySelector(
			'.pemu-single-product .product_title, .entry-title'
		);
		const productName = titleEl ? titleEl.textContent.trim() : 'Product';

		// Loading state
		const origHtml = submitBtn.innerHTML;
		const origText = submitBtn.textContent;
		submitBtn.disabled = true;
		submitBtn.innerHTML =
			'<svg class="animate-spin w-5 h-5 inline mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Adding…';

		const fd = new FormData();
		fd.append('product_id', productId);
		fd.append('quantity', qty);

		fetch(window.pemuData.homeUrl + '?wc-ajax=add_to_cart', {
			method: 'POST',
			body: fd,
		})
			.then((res) => res.text())
			.then((text) => {
				submitBtn.disabled = false;
				submitBtn.innerHTML = origHtml || origText;
				pemuHandleAddedToCart(
					pemuParseWcResponse(text),
					qty,
					productName,
					submitBtn
				);
			})
			.catch(() => {
				submitBtn.disabled = false;
				submitBtn.innerHTML = origHtml || origText;
				pemuHandleAddedToCart(null, qty, productName, submitBtn);
			});
	});

	window.pemuUpdateCartQty = function (key, qty) {
		if (!window.pemuData || !window.pemuData.ajaxUrl) return;
		const n = new FormData();
		n.append('action', 'pemu_update_cart_qty');
		n.append('nonce', window.pemuData.nonce);
		n.append('cart_item_key', key);
		n.append('quantity', qty);
		fetch(window.pemuData.ajaxUrl, { method: 'POST', body: n }).then(() => {
			if (typeof jQuery !== 'undefined') {
				jQuery(document.body).trigger('wc_fragment_refresh');
			}
		});
	};

	// Global qty logic fallback for old inputs
	document.addEventListener('click', function (e) {
		const t = e.target.closest('.pemu-qty-btn');
		if (!t) return;
		const n = t.parentElement.querySelector('input.qty');
		if (!n) return;
		// Don't interfere if Alpine handles it
		if (n.closest('[x-data="qtyInput"]')) return;

		let a = parseFloat(n.value) || 0;
		const o = parseFloat(n.getAttribute('step') || '1');
		const r = parseFloat(n.getAttribute('min') || '0');
		const i = parseFloat(n.getAttribute('max') || '');
		if (t.dataset.action === 'plus') {
			if (i && a >= i) return;
			a += o;
		} else if (t.dataset.action === 'minus') {
			if (a <= r) return;
			a -= o;
		}
		n.value = a;
		n.dispatchEvent(new Event('change', { bubbles: true }));
	});

	document.addEventListener('change', function (t) {
		if (t.target.matches('form.woocommerce-cart-form .qty')) {
			clearTimeout(cartTimer);
			cartTimer = setTimeout(function () {
				const updateBtn = document.querySelector(
					'[name="update_cart"]'
				);
				if (updateBtn) {
					updateBtn.removeAttribute('disabled');
					const form = updateBtn.closest('form');
					if (form) form.style.opacity = '0.5';
					if (typeof jQuery !== 'undefined') {
						jQuery('[name="update_cart"]').trigger('click');
					} else {
						form.submit();
					}
				}
			}, 800);
		}
	});

	document.addEventListener('click', function (e) {
		const t = e.target.closest(
			'.woocommerce-cart-form .remove_from_cart_button'
		);
		if (!t || !window.pemuData) return;
		const n = t.dataset.cart_item_key;
		if (!n) return;
		e.preventDefault();
		const a = t.closest('.cart_item');
		if (a) a.style.opacity = '0.5';
		const o = new FormData();
		o.append('action', 'pemu_remove_cart_item');
		o.append('nonce', window.pemuData.nonce);
		o.append('cart_item_key', n);
		fetch(window.pemuData.ajaxUrl, { method: 'POST', body: o }).then(() => {
			if (window.Alpine)
				Alpine.store('cart').showToast(
					'Item removed',
					'Your cart has been updated.',
					'success'
				);
			window.location.reload();
		});
	});

	window.pemuToggleFilter = function (e, t) {
		var n = new URL(window.location.href);
		if (t) {
			n.searchParams.set(e, '1');
		} else {
			n.searchParams.delete(e);
		}
		n.searchParams.delete('paged');
		window.location.href = n.toString();
	};

	document.addEventListener('DOMContentLoaded', function () {
		document
			.querySelectorAll('.search-form, form[role="search"]')
			.forEach(function (e) {
				if (!e.querySelector('[name="post_type"]')) {
					var t = document.createElement('input');
					t.type = 'hidden';
					t.name = 'post_type';
					t.value = 'product';
					e.appendChild(t);
				}
			});
		const phone = document.getElementById('billing_phone');
		if (phone) {
			phone.addEventListener('input', function () {
				let e = this.value.replace(/\D/g, '');
				if (e.startsWith('254')) e = e.slice(3);
				if (e.startsWith('0')) e = e.slice(1);
				let t = e;
				if (e.length > 3 && e.length <= 6) {
					t = e.slice(0, 3) + ' ' + e.slice(3);
				} else if (e.length > 6) {
					t =
						e.slice(0, 3) +
						' ' +
						e.slice(3, 6) +
						' ' +
						e.slice(6, 9);
				}
				this.value = t;
			});
		}

		// Sticky ATC scroll logic
		const singleProductHero = document.getElementById('product-options');
		if (singleProductHero && window.Alpine) {
			const observer = new IntersectionObserver(
				(entries) => {
					entries.forEach((entry) => {
						Alpine.store('product').stickyATCVisible =
							!entry.isIntersecting;
					});
				},
				{ threshold: 0 }
			);
			observer.observe(singleProductHero);
		}
	});
})();

// ✅ Start Alpine once
document.addEventListener('DOMContentLoaded', () => {
	Alpine.start();
});
