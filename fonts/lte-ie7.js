/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'Arenson\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-AR-Visualization-20121015' : '&#x21;',
			'icon-AR-User-20121015' : '&#x22;',
			'icon-AR-UnFavorited-20121015' : '&#x23;',
			'icon-AR-Tech-Tools-20121015' : '&#x24;',
			'icon-AR-Startup20121015' : '&#x25;',
			'icon-AR-Share-20121015' : '&#x26;',
			'icon-AR-Rental-20121015' : '&#x27;',
			'icon-AR-Real-Estate-20121015' : '&#x28;',
			'icon-AR-Quote-20121015' : '&#x29;',
			'icon-AR-Prop-Center-20121015' : '&#x2a;',
			'icon-AR-Outlet-20121015' : '&#x2b;',
			'icon-AR-Not-for-profit-20121015' : '&#x2c;',
			'icon-AR-logo-Icon-20121015' : '&#x2d;',
			'icon-AR-Logistics-20121015' : '&#x2e;',
			'icon-AR-login-Icon-20121015' : '&#x2f;',
			'icon-AR-Log-Out-20121015' : '&#x30;',
			'icon-AR-Local-to-global-20121015' : '&#x31;',
			'icon-AR-List-Arrow2-20121015' : '&#x32;',
			'icon-AR-List-Arrow1-20121015' : '&#x33;',
			'icon-AR-Install-Service-20121015' : '&#x34;',
			'icon-AR-Hospitality-20121015' : '&#x35;',
			'icon-AR-Healthcare-20121015' : '&#x36;',
			'icon-AR-Government-20121015' : '&#x37;',
			'icon-AR-General-Contracting-20121015' : '&#x38;',
			'icon-AR-Furnishings-20121015' : '&#x39;',
			'icon-AR-Favorite-20121015' : '&#x3a;',
			'icon-AR-Education-20121015' : '&#x3b;',
			'icon-AR-Edit-20121015' : '&#x3c;',
			'icon-AR-Download-PDF-20121015' : '&#x3d;',
			'icon-AR-Download-image-20121015' : '&#x3e;',
			'icon-AR-Download-Binder-20121015' : '&#x3f;',
			'icon-AR-Delete-20121015' : '&#x40;',
			'icon-AR-Counter-20121015' : '&#x41;',
			'icon-AR-Corporate-Commercial-20121015' : '&#x42;',
			'icon-AR-Binder-20121015' : '&#x43;',
			'icon-AR-Architecture-Design-20121015' : '&#x44;',
			'icon-AR-Arch-Products-20121015' : '&#x45;',
			'icon-AR-All-Binders-20121015' : '&#x46;',
			'icon-AR-Add-Binder-20121015' : '&#x47;',
			'icon-AR-Startup20121015-2' : '&#x48;',
			'icon-AR-Right-Arrow-20121015' : '&#x49;',
			'icon-AR-Not-for-profit-20121015-2' : '&#x4a;',
			'icon-AR-Mail-20121015' : '&#x4b;',
			'icon-AR-Left-Arrow-20121015' : '&#x4c;',
			'icon-AR-Arrow-Button-20121015' : '&#x4d;',
			'icon-AR-twitter-20121015' : '&#x4e;',
			'icon-AR-Linkedin-20121015' : '&#x4f;',
			'icon-AR-Facebook-20121015' : '&#x50;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c) {
			addIcon(el, icons[c[0]]);
		}
	}
};