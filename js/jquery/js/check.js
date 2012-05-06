function updateTips(tips, t) {
	tips.text(t).addClass("ui-state-highlight");
	setTimeout(function() {
		tips.removeClass("ui-state-highlight", 1500);
	}, 500);
}

function checkLength(tips, campo, nombrecampo, min, max) {
	if (campo.val().length > max || campo.val().length < min + 1) {
		campo.addClass("ui-state-error");
		updateTips(tips, "La longitud de " + nombrecampo + " debe estar entre "
				+ min + " y " + max + ".");
		return false;
	} else {
		return true;
	}
}

function checkRegexp(tips, o, regexp, n) {
	if (!(regexp.test(o.val()))) {
		o.addClass("ui-state-error");
		updateTips(tips, n);
		return false;
	} else {
		return true;
	}
}

function checkSame(tips, p1, p2, mensaje) {

	if (p1.val() != p2.val()) {
		p1.addClass("ui-state-error");
		p2.addClass("ui-state-error");
		updateTips(tips, mensaje);
		return false;
	} else {
		return true;
	}
}

function checkCaptcha(tips,captcha_img,captcha_text) {
	if (captcha_img.val().toLowerCase() != captcha_text.val().toLowerCase()) {
		captcha_img.addClass("ui-state-error");
		updateTips("El codigo de verificacion no coincide");
		return false;
	} else {
		return true;
	}
}