Calendario = (function () {
	function y(at) {
		at = at || {};
		this.args = at = al(at, {
			animation: !c,
			cont: null,
			bottomBar: true,
			date: true,
			fdow: aq("fdow"),
			min: null,
			max: null,
			reverseWheel: false,
			selection: [],
			selectionType: y.SEL_SINGLE,
			weekNumbers: false,
			align: "Bl/ / /T/r",
			inputField: null,
			trigger: null,
			dateFormat: "%Y-%m-%d",
			opacity: j ? 1 : 3,
			titleFormat: "%b %Y",
			mostrarTime: false,
			timePos: "right",
			time: true,
			minutoStep: 5,
			disabled: ad,
			dateInfo: ad,
			onChange: ad,
			onSelect: ad,
			onTimeChange: ad,
			onFocus: ad,
			onBlur: ad
		});
		this.handlers = {};
		var P = this,
		D = new Date();
		at.min = Y(at.min);
		at.max = Y(at.max);
		if (at.date === true) {
			at.date = D
		}
		if (at.time === true) {
			at.time = D.getHours() * 100 + Math.floor(D.getMinutes() / at.minutoStep) * at.minutoStep
		}
		this.date = Y(at.date);
		this.time = at.time;
		this.fdow = at.fdow;
		m("onChange onSelect onTimeChange onFocus onBlur".split(/\s+/), function (av) {
			var au = at[av];
			if (! (au instanceof Array)) {
				au = [au]
			}
			P.handlers[av] = au
		});
		this.selection = new y.Selection(at.selection, at.selectionType, R, this);
		var ar = K.call(this);
		if (at.cont) {
			W(at.cont).appendChild(ar)
		}
		if (at.trigger) {
			this.manageFields(at.trigger, at.inputField, at.dateFormat)
		}
	}
	var S = navigator.userAgent,
	s = /opera/i.test(S),
	ai = /Konqueror|Safari|KHTML/i.test(S),
	j = /msie/i.test(S) && !s && !(/mac_powerpc/i.test(S)),
	c = j && /msie 6/i.test(S),
	x = /gecko/i.test(S) && !ai && !s && !j,
	l = y.prototype,
	q = y.I18N = {};
	y.SEL_NONE = 0;
	y.SEL_SINGLE = 1;
	y.SEL_MULTIPLE = 2;
	y.SEL_WEEK = 3;
	y.dateToInt = V;
	y.intToDate = B;
	y.printDate = ab;
	y.formatString = k;
	y.i18n = aq;
	y.LANG = function (P, D, ar) {
		q.__ = q[P] = {
			name: D,
			data: ar
		}
	};
	y.setup = function (D) {
		return new y(D)
	};
	l.moveTo = function (aG, aD) {
		aG = Y(aG);
		var aC = af(aG, this.date, true),
		au,
		az = this.args,
		aH = az.min && af(aG, az.min),
		aI = az.max && af(aG, az.max);
		if (!az.animation) {
			aD = false
		}
		ae(aH != null && aH <= 1, [this.els.navPrevMonth, this.els.navPrevYear], "DynarchCalendario-navDisabled");
		ae(aI != null && aI >= -1, [this.els.navNextMonth, this.els.navNextYear], "DynarchCalendario-navDisabled");
		if (aH < -1) {
			aG = az.min;
			au = 1;
			aC = 0
		}
		if (aI > 1) {
			aG = az.max;
			au = 2;
			aC = 0
		}
		this.date = aG;
		this.refresh( !! aD);
		this.callHooks("onChange", this, aG, aD);
		if (aD && !(aC == 0 && aD == 2)) {
			if (this._bodyAnim) {
				this._bodyAnim.stop()
			}
			var aw = this.els.body,
			ax = G("div", "DynarchCalendario-animBody-" + U[aC], aw),
			aF = aw.firstChild,
			av = am(aF) || 0.7,
			ay = au ? Z.brakes : aC == 0 ? Z.shake : Z.accel_ab2,
			aE = aC * aC > 4,
			ar = aE ? aF.offsetTop : aF.offsetLeft,
			aB = ax.style,
			aA = aE ? aw.offsetHeight : aw.offsetWidth;
			if (aC < 0) {
				aA += ar
			} else { if (aC > 0) {
					aA = ar - aA
				} else {
					aA = Math.round(aA / 7);
					if (au == 2) {
						aA = -aA
					}
				}
			}
			if (!au && aC != 0) {
				var P = ax.cloneNode(true),
				D = P.style,
				at = 2 * aA;
				P.appendChild(aF.cloneNode(true));
				D[aE ? "marginTop" : "marginLeft"] = aA + "px";
				aw.appendChild(P)
			}
			aF.style.visibility = "hidden";
			ax.innerHTML = ac(this);
			this._bodyAnim = ap({
				onUpdate: v(function (aK, aM) {
					var aL = ay(aK);
					if (P) {
						var aJ = aM(aL, aA, at) + "px"
					}
					if (au) {
						aB[aE ? "marginTop" : "marginLeft"] = aM(aL, aA, 0) + "px"
					} else { if (aE || aC == 0) {
							aB.marginTop = aM(aC == 0 ? ay(aK * aK) : aL, 0, aA) + "px";
							if (aC != 0) {
								D.marginTop = aJ
							}
						}
						if (!aE || aC == 0) {
							aB.marginLeft = aM(aL, 0, aA) + "px";
							if (aC != 0) {
								D.marginLeft = aJ
							}
						}
					}
					if (this.args.opacity > 2 && P) {
						am(P, 1 - aL);
						am(ax, aL)
					}
				},
				this),
				onStop: v(function (aJ) {
					aw.innerHTML = ac(this, aG);
					this._bodyAnim = null
				},
				this)
			})
		}
		this._lastHoverDate = null;
		return aH >= -1 && aI <= 1
	};
	l.isDisabled = function (D) {
		var P = this.args;
		return (P.min && af(D, P.min) < 0) || (P.max && af(D, P.max) > 0) || P.disabled(D)
	};
	l.toggleMenu = function () {
		u(this, !this._menuVisible)
	};
	l.refresh = function (D) {
		var P = this.els;
		if (!D) {
			P.body.innerHTML = ac(this)
		}
		P.title.innerHTML = F(this);
		P.anoInput.value = this.date.getFullYear()
	};
	l.redraw = function () {
		var D = this.els;
		this.refresh();
		D.diaNames.innerHTML = h(this);
		D.menu.innerHTML = ak(this);
		if (D.bottomBar) {
			D.bottomBar.innerHTML = H(this)
		}
		t(D.topCont, v(function (ar) {
			var P = r[ar.className];
			if (P) {
				D[P] = ar
			}
			if (ar.className == "DynarchCalendario-menu-ano") {
				p(ar, this._focusEventos);
				D.anoInput = ar
			} else { if (j) {
					ar.setAttribute("unselectable", "on")
				}
			}
		},
		this));
		this.setTime(null, true)
	};
	l.setLanguage = function (D) {
		var P = y.setLanguage(D);
		if (P) {
			this.fdow = P.data.fdow;
			this.redraw()
		}
	};
	y.setLanguage = function (D) {
		var P = q[D];
		if (P) {
			q.__ = P
		}
		return P
	};
	l.focus = function () {
		try {
			this.els[this._menuVisible ? "anoInput" : "focusLink"].focus()
		} catch(D) {}
		i.call(this)
	};
	l.blur = function () {
		this.els.focusLink.blur();
		this.els.anoInput.blur();
		z.call(this)
	};
	l.mostrarAt = function (P, ax, av) {
		if (this._mostrarAnim) {
			this._mostrarAnim.stop()
		}
		av = av && this.args.animation;
		var aw = this.els.topCont,
		ar = this,
		D = this.els.body.firstChild,
		au = D.offsetHeight,
		at = aw.style;
		at.position = "absolute";
		at.left = P + "px";
		at.top = ax + "px";
		at.zIndex = 10000;
		at.display = "";
		if (av) {
			D.style.marginTop = -au + "px";
			this.args.opacity > 1 && am(aw, 0);
			this._mostrarAnim = ap({
				onUpdate: function (ay, az) {
					D.style.marginTop = -az(Z.accel_b(ay), au, 0) + "px";
					ar.args.opacity > 1 && am(aw, ay)
				},
				onStop: function () {
					ar.args.opacity > 1 && am(aw, "");
					ar._mostrarAnim = null
				}
			})
		}
	};
	l.hide = function () {
		var at = this.els.topCont,
		P = this,
		D = this.els.body.firstChild,
		ar = D.offsetHeight,
		au = J(at).y;
		if (this.args.animation) {
			if (this._mostrarAnim) {
				this._mostrarAnim.stop()
			}
			this._mostrarAnim = ap({
				onUpdate: function (av, aw) {
					P.args.opacity > 1 && am(at, 1 - av);
					D.style.marginTop = -aw(Z.accel_b(av), 0, ar) + "px";
					at.style.top = aw(Z.accel_ab(av), au, au - 10) + "px"
				},
				onStop: function () {
					at.style.display = "none";
					D.style.marginTop = "";
					P.args.opacity > 1 && am(at, "");
					P._mostrarAnim = null
				}
			})
		} else {
			at.style.display = "none"
		}
		this.inputField = null
	};
	l.popup = function (D, at) {
		D = W(D);
		if (!at) {
			at = this.args.align
		}
		at = at.split(/\x2f/);
		var ar = J(D),
		aw = this.els.topCont,
		ay = aw.style,
		au,
		ax = X();
		ay.visibility = "hidden";
		ay.display = "";
		this.mostrarAt(0, 0);
		document.body.appendChild(aw);
		au = {
			x: aw.offsetWidth,
			y: aw.offsetHeight
		};
		function P(az) {
			var aA = {
				x: av.x,
				y: av.y
			};
			if (!az) {
				return aA
			}
			if (/B/.test(az)) {
				aA.y += D.offsetHeight
			}
			if (/b/.test(az)) {
				aA.y += D.offsetHeight - au.y
			}
			if (/T/.test(az)) {
				aA.y -= au.y
			}
			if (/l/.test(az)) {
				aA.x -= au.x - D.offsetWidth
			}
			if (/L/.test(az)) {
				aA.x -= au.x
			}
			if (/R/.test(az)) {
				aA.x += D.offsetWidth
			}
			if (/c/i.test(az)) {
				aA.x += (D.offsetWidth - au.x) / 2
			}
			if (/m/i.test(az)) {
				aA.y += (D.offsetHeight - au.y) / 2
			}
			return aA
		}
		var av = ar;
		av = P(at[0]);
		if (av.y < ax.y) {
			av.y = ar.y;
			av = P(at[1])
		}
		if (av.x + au.x > ax.x + ax.w) {
			av.x = ar.x;
			av = P(at[2])
		}
		if (av.y + au.y > ax.y + ax.h) {
			av.y = ar.y;
			av = P(at[3])
		}
		if (av.x < ax.x) {
			av.x = ar.x;
			av = P(at[4])
		}
		this.mostrarAt(av.x, av.y, true);
		ay.visibility = "";
		this.focus()
	};
	l.manageFields = function (ar, P, D) {
		P = W(P);
		p(W(ar), "click", v(function () {
			this.inputField = P;
			this.dateFormat = D;
			if (this.selection.type == y.SEL_SINGLE) {
				var aw, av, au, at;
				aw = /input|textarea/i.test(P.tagName) ? P.value : (P.innerText || P.textContent);
				if (aw) {
					av = /(^|[^%])%[bBmo]/.exec(D);
					au = /(^|[^%])%[de]/.exec(D);
					if (av && au) {
						at = av.index < au.index
					}
					aw = Calendario.parsfimData(aw, at);
					if (aw) {
						this.moveTo(aw);
						this.selection.set(aw)
					}
				}
			}
			this.popup(ar)
		},
		this))
	};
	l.callHooks = function (ar) {
		var at = b(arguments, 1),
		D = this.handlers[ar],
		P = 0;
		for (; P < D.length; ++P) {
			D[P].apply(this, at)
		}
	};
	l.addEventListener = function (P, D) {
		this.handlers[P].push(D)
	};
	l.removeEventListener = function (at, ar) {
		var D = this.handlers[at],
		P = D.length;
		while (--P >= 0) {
			if (D[P] === ar) {
				D.splice(P, 1)
			}
		}
	};
	l.getTime = function () {
		return this.time
	};
	l.setTime = function (au, P) {
		if (this.args.mostrarTime) {
			au = this.time = au != null ? au : this.time;
			var ar = this.getHours(),
			D = this.getMinutes(),
			at = ar < 12;
			if (this.args.mostrarTime == 12) {
				if (ar == 0) {
					ar = 12
				}
				if (ar > 12) {
					ar -= 12
				}
				this.els.timeAM.innerHTML = aq(at ? "AM" : "PM")
			}
			if (ar < 10) {
				ar = "0" + ar
			}
			if (D < 10) {
				D = "0" + D
			}
			this.els.timeHour.innerHTML = ar;
			this.els.timeMinute.innerHTML = D;
			if (!P) {
				this.callHooks("onTimeChange", this, au)
			}
		}
	};
	l.getHours = function () {
		return Math.floor(this.time / 100)
	};
	l.getMinutes = function () {
		return this.time % 100
	};
	l.setHours = function (D) {
		if (D < 0) {
			D += 24
		}
		this.setTime(100 * (D % 24) + this.time % 100)
	};
	l.setMinutes = function (D) {
		if (D < 0) {
			D += 60
		}
		this.setTime(100 * this.getHours() + (D % 60))
	};
	l._getInputYear = function () {
		var D = parseInt(this.els.anoInput.value, 10);
		if (isNaN(D)) {
			D = this.date.getFullYear()
		}
		return D
	};
	l._mostrarTooltip = function (D) {
		var P = "",
		at, ar = this.els.tooltip;
		if (D) {
			D = B(D);
			at = this.args.dateInfo(D);
			if (at && at.tooltip) {
				P = "<div class='DynarchCalendario-tooltipCont'>" + ab(D, at.tooltip) + "</div>"
			}
		}
		ar.innerHTML = P
	};
	var ah = " align='center' cellspacing='0' cellpadding='0'";
	function h(D) {
		var ar = ["<table", ah, "><tr>"],
		P = 0;
		if (D.args.weekNumbers) {
			ar.push("<td><div class='DynarchCalendario-weekNumber'>", aq("wk"), "</div></td>")
		}
		while (P < 7) {
			var at = (P+++D.fdow) % 7;
			ar.push("<td><div", aq("weekend").indexOf(at) >= 0 ? " class='DynarchCalendario-weekend'>" : ">", aq("sdn")[at], "</div></td>")
		}
		ar.push("</tr></table>");
		return ar.join("")
	}
	function ac(aw, aG, aD) {
		aG = aG || aw.date;
		aD = aD || aw.fdow;
		aG = new Date(aG);
		var aI = aG.getMonth(),
		av = [],
		aA = 0,
		D = aw.args.weekNumbers;
		aG.setDate(1);
		var az = (aG.getDay() - aD) % 7;
		if (az < 0) {
			az += 7
		}
		aG.setDate(-az);
		aG.setDate(aG.getDate() + 1);
		var aE = new Date(),
		at = aE.getDate(),
		P = aE.getMonth(),
		aJ = aE.getFullYear();
		av[aA++] = "<table class='DynarchCalendario-bodyTable'" + ah + ">";
		for (var aC = 0; aC < 6; ++aC) {
			av[aA++] = "<tr class='DynarchCalendario-week";
			if (aC == 0) {
				av[aA++] = " DynarchCalendario-first-row"
			}
			if (aC == 5) {
				av[aA++] = " DynarchCalendario-last-row"
			}
			av[aA++] = "'>";
			if (D) {
				av[aA++] = "<td class='DynarchCalendario-first-col'><div class='DynarchCalendario-weekNumber'>" + a(aG) + "</div></td>"
			}
			for (var aB = 0; aB < 7; ++aB) {
				var aF = aG.getDate(),
				ay = aG.getMonth(),
				au = aG.getFullYear(),
				ar = 10000 * au + 100 * (ay + 1) + aF,
				aH = aw.selection.isSelected(ar),
				ax = aw.isDisabled(aG), tmp;
				av[aA++] = "<td class='";
				if (aB == 0 && !D) {
					av[aA++] = " DynarchCalendario-first-col"
				}
				if (aB == 0 && aC == 0) {
					aw._firstDateVisible = ar
				}
				if (aB == 6) {
					av[aA++] = " DynarchCalendario-last-col";
					if (aC == 5) {
						aw._lastDateVisible = ar
					}
				}
				if (aH) {
					av[aA++] = " DynarchCalendario-td-selected"
				}
				av[aA++] = "'><div dyc-type='date' unselectable='on' dyc-date='" + ar + "' ";
				if (ax) {
					av[aA++] = "disabled='1' "
				}
				av[aA++] = "class='DynarchCalendario-dia";
				if (aq("weekend").indexOf(aG.getDay()) >= 0) {
					av[aA++] = " DynarchCalendario-weekend"
				}
				if (ay != aI) {
					av[aA++] = " DynarchCalendario-dia-othermes"
				}
				if (aF == at && ay == P && au == aJ) {
					av[aA++] = " DynarchCalendario-dia-todia"
				}
				if (ax) {
					av[aA++] = " DynarchCalendario-dia-disabled"
				}
				if (aH) {
					av[aA++] = " DynarchCalendario-dia-selected"
				}
				ax = aw.args.dateInfo(aG);
				if (ax && ax.klass) {
					av[aA++] = " " + ax.klass
				}
				av[aA++] = "'>" + aF + "</div></td>";
				aG.setDate(aF + 1);
                tmp = aG.getDate();
                if(aF == tmp){
                    aG.setDate(aF + 1);
                }
			}
			av[aA++] = "</tr>"
		}
		av[aA++] = "</table>";
		return av.join("")
	}
	function n(D) {
		var P = ["<table class='DynarchCalendario-topCont'", ah, "><tr><td><div class='DynarchCalendario'>", !j ? "<button class='DynarchCalendario-focusLink'></button>" : "<a class='DynarchCalendario-focusLink' href='#'></a>", "<div class='DynarchCalendario-topBar'><div dyc-type='nav' dyc-btn='-Y' dyc-cls='hover-navBtn,pressed-navBtn' class='DynarchCalendario-navBtn DynarchCalendario-prevYear'><div></div></div><div dyc-type='nav' dyc-btn='+Y' dyc-cls='hover-navBtn,pressed-navBtn' class='DynarchCalendario-navBtn DynarchCalendario-nextYear'><div></div></div><div dyc-type='nav' dyc-btn='-M' dyc-cls='hover-navBtn,pressed-navBtn' class='DynarchCalendario-navBtn DynarchCalendario-prevMonth'><div></div></div><div dyc-type='nav' dyc-btn='+M' dyc-cls='hover-navBtn,pressed-navBtn' class='DynarchCalendario-navBtn DynarchCalendario-nextMonth'><div></div></div><table class='DynarchCalendario-titleCont'", ah, "><tr><td><div dyc-type='title' dyc-btn='menu' dyc-cls='hover-title,pressed-title' class='DynarchCalendario-title'>", F(D), "</div></td></tr></table><div class='DynarchCalendario-diaNames'>", h(D), "</div></div><div class='DynarchCalendario-body'></div>"];
		if (D.args.bottomBar || D.args.mostrarTime) {
			P.push("<div class='DynarchCalendario-bottomBar'>", H(D), "</div>")
		}
		P.push("<div class='DynarchCalendario-menu' style='display: none'>", ak(D), "</div><div class='DynarchCalendario-tooltip'></div></div></td></tr></table>");
		return P.join("")
	}
	function F(D) {
		return "<div unselectable='on'>" + ab(D.date, D.args.titleFormat) + "</div>"
	}
	function ak(P) {
		var au = ["<table height='100%'", ah, "><tr><td><table style='margin-top: 1.5em'", ah, "><tr><td colspan='3'><input dyc-btn='ano' class='DynarchCalendario-menu-ano' size='6' value='", P.date.getFullYear(), "' /></td></tr><tr><td><div dyc-type='menubtn' dyc-cls='hover-navBtn,pressed-navBtn' dyc-btn='todia'>", aq("goTodia"), "</div></td></tr></table><p class='DynarchCalendario-menu-sep'>&nbsp;</p><table class='DynarchCalendario-menu-mtable'", ah, ">"],
		av = aq("smn"),
		at = 0,
		D = au.length,
		ar;
		while (at < 12) {
			au[D++] = "<tr>";
			for (ar = 4; --ar > 0;) {
				au[D++] = "<td><div dyc-type='menubtn' dyc-cls='hover-navBtn,pressed-navBtn' dyc-btn='m" + at + "' class='DynarchCalendario-menu-mes'>" + av[at++] + "</div></td>"
			}
			au[D++] = "</tr>"
		}
		au[D++] = "</table></td></tr></table>";
		return au.join("")
	}
	function w(D, P) {
		P.push("<table class='DynarchCalendario-time'" + ah + "><tr><td rowspan='2'><div dyc-type='time-hora' dyc-cls='hover-time,pressed-time' class='DynarchCalendario-time-hora'></div></td><td dyc-type='time-hora+' dyc-cls='hover-time,pressed-time' class='DynarchCalendario-time-up'></td><td rowspan='2' class='DynarchCalendario-time-sep'></td><td rowspan='2'><div dyc-type='time-min' dyc-cls='hover-time,pressed-time' class='DynarchCalendario-time-minuto'></div></td><td dyc-type='time-min+' dyc-cls='hover-time,pressed-time' class='DynarchCalendario-time-up'></td>");
		if (D.args.mostrarTime == 12) {
			P.push("<td rowspan='2' class='DynarchCalendario-time-sep'></td><td rowspan='2'><div class='DynarchCalendario-time-am' dyc-type='time-am' dyc-cls='hover-time,pressed-time'></div></td>")
		}
		P.push("</tr><tr><td dyc-type='time-hora-' dyc-cls='hover-time,pressed-time' class='DynarchCalendario-time-down'></td><td dyc-type='time-min-' dyc-cls='hover-time,pressed-time' class='DynarchCalendario-time-down'></td></tr></table>")
	}
	function H(D) {
		var ar = [],
		P = D.args;
		ar.push("<table", ah, " style='width:100%'><tr>");
		function at() {
			if (P.mostrarTime) {
				ar.push("<td>");
				w(D, ar);
				ar.push("</td>")
			}
		}
		if (P.timePos == "left") {
			at()
		}
		if (P.bottomBar) {
			ar.push("<td>");
			ar.push("<table", ah, "><tr><td><div dyc-btn='todia' dyc-cls='hover-bottomBar-todia,pressed-bottomBar-todia' dyc-type='bottomBar-todia' class='DynarchCalendario-bottomBar-todia'>", aq("todia"), "</div></td></tr></table>");
			ar.push("</td>")
		}
		if (P.timePos == "right") {
			at()
		}
		ar.push("</tr></table>");
		return ar.join("")
	}
	var r = {
		"DynarchCalendario-topCont": "topCont",
		"DynarchCalendario-focusLink": "focusLink",
		DynarchCalendario: "main",
		"DynarchCalendario-topBar": "topBar",
		"DynarchCalendario-title": "title",
		"DynarchCalendario-diaNames": "diaNames",
		"DynarchCalendario-body": "body",
		"DynarchCalendario-menu": "menu",
		"DynarchCalendario-menu-ano": "anoInput",
		"DynarchCalendario-bottomBar": "bottomBar",
		"DynarchCalendario-tooltip": "tooltip",
		"DynarchCalendario-time-hora": "timeHour",
		"DynarchCalendario-time-minuto": "timeMinute",
		"DynarchCalendario-time-am": "timeAM",
		"DynarchCalendario-navBtn DynarchCalendario-prevYear": "navPrevYear",
		"DynarchCalendario-navBtn DynarchCalendario-nextYear": "navNextYear",
		"DynarchCalendario-navBtn DynarchCalendario-prevMonth": "navPrevMonth",
		"DynarchCalendario-navBtn DynarchCalendario-nextMonth": "navNextMonth"
	};
	function K() {
		var ar = G("div"),
		P = this.els = {},
		D = {
			mousedown: v(I, this, true),
			mouseup: v(I, this, false),
			mouseover: v(T, this, true),
			mouseout: v(T, this, false),
			keypress: v(L, this)
		};
		D[x ? "DOMMouseScroll" : "mousewheel"] = v(E, this);
		if (j) {
			D.dblclick = D.mousedown;
			D.keydown = D.keypress
		}
		ar.innerHTML = n(this);
		t(ar.firstChild, function (au) {
			var at = r[au.className];
			if (at) {
				P[at] = au
			}
			if (j) {
				au.setAttribute("unselectable", "on")
			}
		});
		p(P.main, D);
		p([P.focusLink, P.anoInput], this._focusEventos = {
			focus: v(i, this),
			blur: v(e, this)
		});
		this.moveTo(this.date, false);
		this.setTime(null, true);
		return P.topCont
	}
	function i() {
		if (this._bluringTimeout) {
			clearTimeout(this._bluringTimeout)
		}
		this.focused = true;
		M(this.els.main, "DynarchCalendario-focused");
		this.callHooks("onFocus", this)
	}
	function z() {
		this.focused = false;
		aj(this.els.main, "DynarchCalendario-focused");
		if (this._menuVisible) {
			u(this, false)
		}
		if (!this.args.cont) {
			this.hide()
		}
		this.callHooks("onBlur", this)
	}
	function e() {
		this._bluringTimeout = setTimeout(v(z, this), 50)
	}
	function N(D) {
		switch (D) {
		case "time-hora+":
			this.setHours(this.getHours() + 1);
			break;
		case "time-hora-":
			this.setHours(this.getHours() - 1);
			break;
		case "time-min+":
			this.setMinutes(this.getMinutes() + this.args.minutoStep);
			break;
		case "time-min-":
			this.setMinutes(this.getMinutes() - this.args.minutoStep);
			break;
		default:
			return
		}
	}
	var U = {
		"-3": "backYear",
		"-2": "back",
		"0": "now",
		"2": "fwd",
		"3": "fwdYear"
	};
	function aa(P, at, D) {
		if (this._bodyAnim) {
			this._bodyAnim.stop()
		}
		var ar;
		if (at != 0) {
			ar = new Date(P.date);
			ar.setDate(1);
			switch (at) {
			case "-Y":
			case -2:
				ar.setFullYear(ar.getFullYear() - 1);
				break;
			case "+Y":
			case 2:
				ar.setFullYear(ar.getFullYear() + 1);
				break;
			case "-M":
			case -1:
				ar.setMonth(ar.getMonth() - 1);
				break;
			case "+M":
			case 1:
				ar.setMonth(ar.getMonth() + 1);
				break
			}
		} else {
			ar = new Date()
		}
		return P.moveTo(ar, !D)
	}
	function u(ar, P) {
		ar._menuVisible = P;
		ae(P, ar.els.title, "DynarchCalendario-pressed-title");
		var at = ar.els.menu;
		if (c) {
			at.style.height = ar.els.main.offsetHeight + "px"
		}
		if (!ar.args.animation) {
			O(at, P);
			if (ar.focused) {
				ar.focus()
			}
		} else { if (ar._menuAnim) {
				ar._menuAnim.stop()
			}
			var D = ar.els.main.offsetHeight;
			if (c) {
				at.style.width = ar.els.topBar.offsetWidth + "px"
			}
			if (P) {
				at.firstChild.style.marginTop = -D + "px";
				ar.args.opacity > 0 && am(at, 0);
				O(at, true)
			}
			ar._menuAnim = ap({
				onUpdate: function (au, av) {
					at.firstChild.style.marginTop = av(Z.accel_b(au), -D, 0, !P) + "px";
					ar.args.opacity > 0 && am(at, av(Z.accel_b(au), 0, 0.85, !P))
				},
				onStop: function () {
					ar.args.opacity > 0 && am(at, 0.85);
					at.firstChild.style.marginTop = "";
					ar._menuAnim = null;
					if (!P) {
						O(at, false);
						if (ar.focused) {
							ar.focus()
						}
					}
				}
			})
		}
	}
	function I(az, ay) {
		ay = ay || window.evento;
		var au = o(ay);
		if (au && !au.getAttribute("disabled")) {
			var D = au.getAttribute("dyc-btn"),
			ax = au.getAttribute("dyc-type"),
			av = au.getAttribute("dyc-date"),
			at = this.selection,
			ar,
			P = {
				mouseover: an,
				mousemove: an,
				mouseup: function (aC) {
					var aB = au.getAttribute("dyc-cls");
					if (aB) {
						aj(au, ao(aB, 1))
					}
					clearTimeout(ar);
					d(document, P, true);
					P = null
				}
			};
			if (az) {
				setTimeout(v(this.focus, this), 1);
				var aA = au.getAttribute("dyc-cls");
				if (aA) {
					M(au, ao(aA, 1))
				}
				if ("menu" == D) {
					this.toggleMenu()
				} else { if (au && /^[+-][MY]$/.test(D)) {
						if (aa(this, D)) {
							var aw = v(function () {
								if (aa(this, D, true)) {
									ar = setTimeout(aw, 40)
								} else {
									P.mouseup();
									aa(this, D)
								}
							},
							this);
							ar = setTimeout(aw, 350);
							p(document, P, true)
						} else {
							P.mouseup()
						}
					} else { if ("ano" == D) {
							this.els.anoInput.focus();
							this.els.anoInput.select()
						} else { if (ax == "time-am") {
								p(document, P, true)
							} else { if (/^time/.test(ax)) {
									var aw = v(function (aB) {
										N.call(this, aB);
										ar = setTimeout(aw, 100)
									},
									this, ax);
									N.call(this, ax);
									ar = setTimeout(aw, 350);
									p(document, P, true)
								} else { if (av && at.type) {
										if (at.type == y.SEL_MULTIPLE) {
											if (ay.shiftKey && this._selRangeStart) {
												at.selectRange(this._selRangeStart, av)
											} else { if (!ay.ctrlKey && !at.isSelected(av)) {
													at.clear(true)
												}
												at.set(av, true);
												this._selRangeStart = av
											}
										} else {
											at.set(av);
											this.moveTo(B(av), 2)
										}
										au = this._getDateDiv(av);
										T.call(this, true, {
											target: au
										})
									}
									p(document, P, true)
								}
							}
						}
					}
				}
				if (j && P && /dbl/i.test(ay.type)) {
					P.mouseup()
				}
				if (/^(DynarchCalendario-(topBar|bottomBar|weekend|weekNumber|menu(-sep)?))?$/.test(au.className) && !this.args.cont) {
					P.mousemove = v(g, this);
					this._mouseDiff = f(ay, J(this.els.topCont));
					p(document, P, true)
				}
			} else { if ("todia" == D) {
					if (!this._menuVisible && at.type == y.SEL_SINGLE) {
						at.set(new Date())
					}
					this.moveTo(new Date(), true);
					u(this, false)
				} else { if (/^m([0-9]+)/.test(D)) {
						var av = new Date(this.date);
						av.setDate(1);
						av.setMonth(RegExp.$1);
						av.setFullYear(this._getInputYear());
						this.moveTo(av, true);
						u(this, false)
					} else { if (ax == "time-am") {
							this.setHours(this.getHours() + 12)
						}
					}
				}
			}
			if (!j) {
				an(ay)
			}
		}
	}
	function g(P) {
		P = P || window.evento;
		var D = this.els.topCont.style,
		ar = f(P, this._mouseDiff);
		D.left = ar.x + "px";
		D.top = ar.y + "px"
	}
	function o(P) {
		var D = P.target || P.srcElement,
		ar = D;
		while (D && D.getAttribute && !D.getAttribute("dyc-type")) {
			D = D.parentNode
		}
		return D.getAttribute && D || ar
	}
	function ao(D, P) {
		return "DynarchCalendario-" + D.split(/,/)[P]
	}
	function T(au, at) {
		at = at || window.evento;
		var ar = o(at);
		if (ar) {
			var P = ar.getAttribute("dyc-type");
			if (P && !ar.getAttribute("disabled")) {
				if (!au || !this._bodyAnim || P != "date") {
					var D = ar.getAttribute("dyc-cls");
					D = D ? ao(D, 0) : "DynarchCalendario-hover-" + P;
					if (P != "date" || this.selection.type) {
						ae(au, ar, D)
					}
					if (P == "date") {
						ae(au, ar.parentNode.parentNode, "DynarchCalendario-hover-week");
						this._mostrarTooltip(ar.getAttribute("dyc-date"))
					}
					if (/^time-hora/.test(P)) {
						ae(au, this.els.timeHour, "DynarchCalendario-hover-time")
					}
					if (/^time-min/.test(P)) {
						ae(au, this.els.timeMinute, "DynarchCalendario-hover-time")
					}
					aj(this._getDateDiv(this._lastHoverDate), "DynarchCalendario-hover-date");
					this._lastHoverDate = null
				}
			}
		}
		if (!au) {
			this._mostrarTooltip()
		}
	}
	function E(ar) {
		ar = ar || window.evento;
		var P = o(ar);
		if (P) {
			var at = P.getAttribute("dyc-btn"),
			D = P.getAttribute("dyc-type"),
			au = ar.wheelDelta ? ar.wheelDelta / 120 : -ar.detail / 3;
			au = au < 0 ? -1 : au > 0 ? 1 : 0;
			if (this.args.reverseWheel) {
				au = -au
			}
			if (/^(time-(hora|min))/.test(D)) {
				switch (RegExp.$1) {
				case "time-hora":
					this.setHours(this.getHours() + au);
					break;
				case "time-min":
					this.setMinutes(this.getMinutes() + this.args.minutoStep * au);
					break
				}
				an(ar)
			} else { if (/Y/i.test(at)) {
					au *= 2
				}
				aa(this, -au);
				an(ar)
			}
		}
	}
	function R() {
		this.refresh();
		var D = this.inputField,
		P = this.selection;
		if (D) {
			var ar = P.print(this.dateFormat);
			(/input|textarea/i.test(D.tagName)) ? D.value = ar : D.innerHTML = ar
		}
		this.callHooks("onSelect", this, P)
	}
	var ag = {
		37: -1,
		38: -2,
		39: 1,
		40: 2
	},
	Q = {
		33: -1,
		34: 1
	};
	function L(aB) {
		if (this._menuAnim) {
			return
		}
		aB = aB || window.evento;
		var ar = aB.target || aB.srcElement,
		aC = ar.getAttribute("dyc-btn"),
		aD = aB.keyCode,
		ay = aB.charCode || aD,
		D = ag[aD];
		if ("ano" == aC && aD == 13) {
			var au = new Date(this.date);
			au.setDate(1);
			au.setFullYear(this._getInputYear());
			this.moveTo(au, true);
			u(this, false);
			return an(aB)
		}
		if (this._menuVisible) {
			if (aD == 27) {
				u(this, false);
				return an(aB)
			}
		} else { if (!aB.ctrlKey) {
				D = null
			}
			if (D == null && !aB.ctrlKey) {
				D = Q[aD]
			}
			if (aD == 36) {
				D = 0
			}
			if (D != null) {
				aa(this, D);
				return an(aB)
			}
			ay = String.fromCharCode(ay).toLowerCase();
			var ax = this.els.anoInput,
			P = this.selection;
			if (ay == " ") {
				u(this, true);
				this.focus();
				ax.focus();
				ax.select();
				return an(aB)
			}
			if (ay >= "0" && ay <= "9") {
				u(this, true);
				this.focus();
				ax.value = ay;
				ax.focus();
				return an(aB)
			}
			var av = aq("mn"),
			az = aB.shiftKey ? -1 : this.date.getMonth(),
			aw = 0,
			at;
			while (++aw < 12) {
				at = av[(az + aw) % 12].toLowerCase();
				if (at.indexOf(ay) == 0) {
					var au = new Date(this.date);
					au.setDate(1);
					au.setMonth((az + aw) % 12);
					this.moveTo(au, true);
					return an(aB)
				}
			}
			if (aD >= 37 && aD <= 40) {
				var au = this._lastHoverDate;
				if (!au && !P.isEmpty()) {
					au = aD < 39 ? P.getFirstDate() : P.getLastDate();
					if (au < this._firstDateVisible || au > this._lastDateVisible) {
						au = null
					}
				}
				if (!au) {
					au = aD < 39 ? this._lastDateVisible : this._firstDateVisible
				} else {
					var aA = au;
					au = B(au);
					var az = 100;
					while (az -->
					0) {
						switch (aD) {
						case 37:
							au.setDate(au.getDate() - 1);
							break;
						case 38:
							au.setDate(au.getDate() - 7);
							break;
						case 39:
							au.setDate(au.getDate() + 1);
							break;
						case 40:
							au.setDate(au.getDate() + 7);
							break
						}
						if (!this.isDisabled(au)) {
							break
						}
					}
					au = V(au);
					if (au < this._firstDateVisible || au > this._lastDateVisible) {
						this.moveTo(au)
					}
				}
				aj(this._getDateDiv(aA), M(this._getDateDiv(au), "DynarchCalendario-hover-date"));
				this._lastHoverDate = au;
				return an(aB)
			}
			if (aD == 13) {
				if (this._lastHoverDate) {
					if (P.type == y.SEL_MULTIPLE && (aB.shiftKey || aB.ctrlKey)) {
						if (aB.shiftKey && this._selRangeStart) {
							P.clear(true);
							P.selectRange(this._selRangeStart, this._lastHoverDate)
						}
						if (aB.ctrlKey) {
							P.set(this._selRangeStart = this._lastHoverDate, true)
						}
					} else {
						P.reset(this._selRangeStart = this._lastHoverDate)
					}
					return an(aB)
				}
			}
			if (aD == 27 && !this.args.cont) {
				this.hide()
			}
		}
	}
	l._getDateDiv = function (D) {
		var ar = null;
		if (D) {
			try {
				t(this.els.body, function (at) {
					if (at.getAttribute("dyc-date") == D) {
						throw ar = at
					}
				})
			} catch(P) {}
		}
		return ar
	};
	function k(D, P) {
		return D.replace(/\$\{([^:\}]+)(:[^\}]+)?\}/g, function (av, au, at) {
			var aw = P[au],
			ar;
			if (at) {
				ar = at.substr(1).split(/\s*\|\s*/);
				aw = (aw >= ar.length ? ar[ar.length - 1] : ar[aw]).replace(/##?/g, function (ax) {
					return ax.length == 2 ? "#" : aw
				})
			}
			return aw
		})
	}
	function aq(ar, P) {
		var D = q.__.data[ar];
		if (P && typeof D == "string") {
			D = k(D, P)
		}
		return D
	} (y.Selection = function (ar, P, D, at) {
		this.type = P;
		this.sel = ar instanceof Array ? ar : [ar];
		this.onChange = v(D, at);
		this.cal = at
	}).prototype = {
		get: function () {
			return this.type == y.SEL_SINGLE ? this.sel[0] : this.sel
		},
		isEmpty: function () {
			return this.sel.length == 0
		},
		set: function (P, D) {
			var ar = this.type == y.SEL_SINGLE;
			if (P instanceof Array) {
				this.sel = P;
				this.normalize();
				this.onChange(this)
			} else {
				P = V(P);
				if (ar || !this.isSelected(P)) {
					ar ? this.sel = [P] : this.sel.splice(this.findInsertPos(P), 0, P);
					this.normalize();
					this.onChange(this)
				} else { if (D) {
						this.unselect(P)
					}
				}
			}
		},
		reset: function () {
			this.sel = [];
			this.set.apply(this, arguments)
		},
		countDays: function () {
			var av = 0,
			D = this.sel,
			P = D.length,
			at, au, ar;
			while (--P >= 0) {
				at = D[P];
				if (at instanceof Array) {
					au = B(at[0]);
					ar = B(at[1]);
					av += Math.round(Math.abs(ar.getTime() - au.getTime()) / 86400000)
				}++av
			}
			return av
		},
		unselect: function (P) {
			P = V(P);
			var ax = false;
			for (var D = this.sel, at = D.length, av; --at >= 0;) {
				av = D[at];
				if (av instanceof Array) {
					if (P >= av[0] && P <= av[1]) {
						var ar = B(P),
						aw = ar.getDate();
						if (P == av[0]) {
							ar.setDate(aw + 1);
							av[0] = V(ar);
							ax = true
						} else { if (P == av[1]) {
								ar.setDate(aw - 1);
								av[1] = V(ar);
								ax = true
							} else {
								var au = new Date(ar);
								au.setDate(aw + 1);
								ar.setDate(aw - 1);
								D.splice(at + 1, 0, [V(au), av[1]]);
								av[1] = V(ar);
								ax = true
							}
						}
					}
				} else { if (P == av) {
						D.splice(at, 1);
						ax = true
					}
				}
			}
			if (ax) {
				this.normalize();
				this.onChange(this)
			}
		},
		normalize: function () {
			this.sel = this.sel.sort(function (ay, ax) {
				if (ay instanceof Array) {
					ay = ay[0]
				}
				if (ax instanceof Array) {
					ax = ax[0]
				}
				return ay - ax
			});
			for (var P = this.sel, ar = P.length, av, au; --ar >= 0;) {
				av = P[ar];
				if (av instanceof Array) {
					if (av[0] > av[1]) {
						P.splice(ar, 1);
						continue
					}
					if (av[0] == av[1]) {
						av = P[ar] = av[0]
					}
				}
				if (au) {
					var at = au,
					aw = av instanceof Array ? av[1] : av;
					aw = B(aw);
					aw.setDate(aw.getDate() + 1);
					aw = V(aw);
					if (aw >= at) {
						var D = P[ar + 1];
						if (av instanceof Array && D instanceof Array) {
							av[1] = D[1];
							P.splice(ar + 1, 1)
						} else { if (av instanceof Array) {
								av[1] = au;
								P.splice(ar + 1, 1)
							} else { if (D instanceof Array) {
									D[0] = av;
									P.splice(ar, 1)
								} else {
									P[ar] = [av, D];
									P.splice(ar + 1, 1)
								}
							}
						}
					}
				}
				au = av instanceof Array ? av[0] : av
			}
		},
		findInsertPos: function (P) {
			for (var D = this.sel, ar = D.length, at; --ar >= 0;) {
				at = D[ar];
				if (at instanceof Array) {
					at = at[0]
				}
				if (at <= P) {
					break
				}
			}
			return ar + 1
		},
		clear: function (D) {
			this.sel = [];
			if (!D) {
				this.onChange(this)
			}
		},
		selectRange: function (ar, P) {
			ar = V(ar);
			P = V(P);
			if (ar > P) {
				var D = ar;
				ar = P;
				P = D
			}
			this.sel.push([ar, P]);
			this.normalize();
			this.onChange(this)
		},
		isSelected: function (D) {
			for (var P = this.sel.length, ar; --P >= 0;) {
				ar = this.sel[P];
				if (ar instanceof Array && D >= ar[0] && D <= ar[1] || D == ar) {
					return true
				}
			}
			return false
		},
		getFirstDate: function () {
			var D = this.sel[0];
			if (D && D instanceof Array) {
				D = D[0]
			}
			return D
		},
		getLastDate: function () {
			if (this.sel.length > 0) {
				var D = this.sel[this.sel.length - 1];
				if (D && D instanceof Array) {
					D = D[1]
				}
				return D
			}
		},
		print: function (ar, at) {
			var P = [],
			au = 0,
			aw,
			av = this.cal.getHours(),
			D = this.cal.getMinutes();
			if (!at) {
				at = " -> "
			}
			while (au < this.sel.length) {
				aw = this.sel[au++];
				if (aw instanceof Array) {
					P.push(ab(B(aw[0], av, D), ar) + at + ab(B(aw[1], av, D), ar))
				} else {
					P.push(ab(B(aw, av, D), ar))
				}
			}
			return P
		},
		getDates: function (P) {
			var D = [],
			ar = 0,
			au,
			at;
			while (ar < this.sel.length) {
				at = this.sel[ar++];
				if (at instanceof Array) {
					au = B(at[0]);
					at = at[1];
					while (V(au) < at) {
						D.push(P ? ab(au, P) : new Date(au));
						au.setDate(au.getDate() + 1)
					}
				} else {
					au = B(at)
				}
				D.push(P ? ab(au, P) : au)
			}
			return D
		}
	};
	function a(P) {
		P = new Date(P.getFullYear(), P.getMonth(), P.getDate(), 12, 0, 0);
		var ar = P.getDay();
		P.setDate(P.getDate() - (ar + 6) % 7 + 3);
		var D = P.valueOf();
		P.setMonth(0);
		P.setDate(4);
		return Math.round((D - P.valueOf()) / (7 * 86400000)) + 1
	}
	function C(D) {
		D = new Date(D.getFullYear(), D.getMonth(), D.getDate(), 0, 0, 0);
		var ar = new Date(D.getFullYear(), 0, 1, 12, 0, 0);
		var P = D - ar;
		return Math.floor(P / 86400000)
	}
	function V(D) {
		if (D instanceof Date) {
			return 10000 * D.getFullYear() + 100 * (D.getMonth() + 1) + D.getDate()
		}
		if (typeof D == "string") {
			return parseInt(D, 10)
		}
		return D
	}
	function B(ar, au, av, at, P) {
		if (! (ar instanceof Date)) {
			ar = parseInt(ar);
			var aw = Math.floor(ar / 10000);
			ar = ar % 10000;
			var D = Math.floor(ar / 100);
			ar = ar % 100;
			ar = new Date(aw, D - 1, ar, au || 12, av || 0, at || 0, P || 0)
		}
		return ar
	}
	function af(aw, au, ar) {
		var av = aw.getFullYear(),
		ay = aw.getMonth(),
		P = aw.getDate(),
		at = au.getFullYear(),
		ax = au.getMonth(),
		D = au.getDate();
		return av < at ? -3 : av > at ? 3 : ay < ax ? -2 : ay > ax ? 2 : ar ? 0 : P < D ? -1 : P > D ? 1 : 0
	}
	function ab(D, ax) {
		var P = D.getMonth(),
		aw = D.getDate(),
		ay = D.getFullYear(),
		az = a(D),
		aA = D.getDay(),
		aB = D.getHours(),
		ar = (aB >= 12),
		au = (ar) ? (aB - 12) : aB,
		aD = C(D),
		at = D.getMinutes(),
		av = D.getSeconds(),
		aC = /%./g,
		aE;
		if (au === 0) {
			au = 12
		}
		aE = {
			"%a": aq("sdn")[aA],
			"%A": aq("dn")[aA],
			"%b": aq("smn")[P],
			"%B": aq("mn")[P],
			"%C": 1 + Math.floor(ay / 100),
			"%d": aw < 10 ? "0" + aw : aw,
			"%e": aw,
			"%H": aB < 10 ? "0" + aB : aB,
			"%I": au < 10 ? "0" + au : au,
			"%j": aD < 10 ? "00" + aD : aD < 100 ? "0" + aD : aD,
			"%k": aB,
			"%l": au,
			"%m": P < 9 ? "0" + (1 + P) : 1 + P,
			"%o": 1 + P,
			"%M": at < 10 ? "0" + at : at,
			"%n": "\n",
			"%p": ar ? "PM" : "AM",
			"%P": ar ? "pm" : "am",
			"%s": Math.floor(D.getTime() / 1000),
			"%S": av < 10 ? "0" + av : av,
			"%t": "\t",
			"%U": az < 10 ? "0" + az : az,
			"%W": az < 10 ? "0" + az : az,
			"%V": az < 10 ? "0" + az : az,
			"%u": aA + 1,
			"%w": aA,
			"%y": ("" + ay).substr(2, 2),
			"%Y": ay,
			"%%": "%"
		};
		return ax.replace(aC, function (aF) {
			return aE.hasOwnProperty(aF) ? aE[aF] : aF
		})
	}
	function Y(P) {
		if (P) {
			if (typeof P == "number") {
				return B(P)
			}
			if (! (P instanceof Date)) {
				var D = P.split(/-/);
				return new Date(parseInt(D[0], 10), parseInt(D[1], 10) - 1, parseInt(D[2], 10), 12, 0, 0, 0)
			}
		}
		return P
	}
	function A(ar) {
		ar = ar.toLowerCase();
		function P(at) {
			for (var au = at.length; --au >= 0;) {
				if (at[au].toLowerCase().indexOf(ar) == 0) {
					return au
				}
			}
		}
		var D = P(aq("smn")) || P(aq("mn"));
		if (D != null) {
			D++
		}
		return D
	}
	y.parsfimData = function (au, D, aw) {
		if (!/\S/.test(au)) {
			return ""
		}
		au = au.replace(/^\s+/, "").replace(/\s+$/, "");
		aw = aw || new Date();
		var aB = null,
		P = null,
		aD = null,
		av = null,
		ar = null,
		aC = null;
		var ay = au.match(/([0-9]{1,2}):([0-9]{1,2})(:[0-9]{1,2})?\s*(am|pm)?/i);
		if (ay) {
			av = parseInt(ay[1], 10);
			ar = parseInt(ay[2], 10);
			aC = ay[3] ? parseInt(ay[3].substr(1), 10) : 0;
			au = au.substring(0, ay.index) + au.substr(ay.index + ay[0].length);
			if (ay[4]) {
				if (ay[4].toLowerCase() == "pm" && av < 12) {
					av += 12
				} else { if (ay[4].toLowerCase() == "am" && av >= 12) {
						av -= 12
					}
				}
			}
		}
		var az = au.split(/\W+/);
		var ax = [];
		for (var at = 0; at < az.length; ++at) {
			var aA = az[at];
			if (/^[0-9]{4}$/.test(aA)) {
				aB = parseInt(aA, 10);
				if (!P && !aD && D == null) {
					D = true
				}
			} else { if (/^[0-9]{1,2}$/.test(aA)) {
					aA = parseInt(aA, 10);
					if (aA >= 60) {
						aB = aA
					} else { if (aA >= 0 && aA <= 12) {
							ax.push(aA)
						} else { if (aA >= 1 && aA <= 31) {
								aD = aA
							}
						}
					}
				} else {
					P = A(aA)
				}
			}
		}
		if (ax.length >= 2) {
			if (D) {
				if (!P) {
					P = ax.shift()
				}
				if (!aD) {
					aD = ax.shift()
				}
			} else { if (!aD) {
					aD = ax.shift()
				}
				if (!P) {
					P = ax.shift()
				}
			}
		} else { if (ax.length == 1) {
				if (!aD) {
					aD = ax.shift()
				} else { if (!P) {
						P = ax.shift()
					}
				}
			}
		}
		if (!aB) {
			aB = ax.length > 0 ? ax.shift() : aw.getFullYear()
		}
		if (aB < 30) {
			aB += 2000
		} else { if (aB < 99) {
				aB += 1900
			}
		}
		if (!P) {
			P = aw.getMonth() + 1
		}
		return aB && P && aD ? new Date(aB, P - 1, aD, av, ar, aC) : null
	};
	function al(D, at, P, ar) {
		ar = {};
		for (P in at) {
			if (at.hasOwnProperty(P)) {
				ar[P] = at[P]
			}
		}
		for (P in D) {
			if (D.hasOwnProperty(P)) {
				ar[P] = D[P]
			}
		}
		return ar
	}
	function p(ar, au, at, D) {
		if (ar instanceof Array) {
			for (var P = ar.length; --P >= 0;) {
				p(ar[P], au, at, D)
			}
		} else { if (typeof au == "object") {
				for (var P in au) {
					if (au.hasOwnProperty(P)) {
						p(ar, P, au[P], at)
					}
				}
			} else { if (ar && ar.addEventListener) {
					ar.addEventListener(au, at, j ? true : !!D)
				} else { if (ar && ar.attachEvent) {
						ar.attachEvent("on" + au, at)
					} else if(ar) {
						ar["on" + au] = at
					}
				}
			}
		}
	}
	function d(ar, au, at, D) {
		if (ar instanceof Array) {
			for (var P = ar.length; --P >= 0;) {
				d(ar[P], au, at)
			}
		} else { if (typeof au == "object") {
				for (var P in au) {
					if (au.hasOwnProperty(P)) {
						d(ar, P, au[P], at)
					}
				}
			} else { if (ar.removeEventListener) {
					ar.removeEventListener(au, at, j ? true : !!D)
				} else { if (ar.detachEvent) {
						ar.detachEvent("on" + au, at)
					} else {
						ar["on" + au] = null
					}
				}
			}
		}
	}
	function an(D) {
		D = D || window.evento;
		if (j) {
			D.cancelBubble = true;
			D.returnValue = false
		} else {
			D.preventDefault();
			D.stopPropagation()
		}
		return false
	}
	function aj(au, at, av) {
		if (au) {
			var D = au.className.replace(/^\s+|\s+$/, "").split(/\x20/),
			P = [],
			ar;
			for (ar = D.length; ar > 0;) {
				if (D[--ar] != at) {
					P.push(D[ar])
				}
			}
			if (av) {
				P.push(av)
			}
			au.className = P.join(" ")
		}
		return av
	}
	function M(P, D) {
		return aj(P, D, D)
	}
	function ae(at, ar, P) {
		if (ar instanceof Array) {
			for (var D = ar.length; --D >= 0;) {
				ae(at, ar[D], P)
			}
		} else {
			aj(ar, P, at ? P : null)
		}
		return at
	}
	function G(at, D, ar) {
		var P = null;
		if (document.createElementNS) {
			P = document.createElementNS("http://www.w3.org/1999/xhtml", at)
		} else {
			P = document.createElement(at)
		}
		if (D) {
			P.className = D
		}
		if (ar) {
			ar.appendChild(P)
		}
		return P
	}
	function b(au, av) {
		if (av == null) {
			av = 0
		}
		var D, at, P;
		try {
			D = Array.prototype.slice.call(au, av)
		} catch(ar) {
			D = new Array(au.length - av);
			for (at = av, P = 0; at < au.length; ++at, ++P) {
				D[P] = au[at]
			}
		}
		return D
	}
	function v(P, ar) {
		var D = b(arguments, 2);
		return (ar == undefined ?
		function () {
			return P.apply(this, D.concat(b(arguments)))
		} : function () {
			return P.apply(ar, D.concat(b(arguments)))
		})
	}
	function t(P, ar) {
		if (!ar(P)) {
			for (var D = P.firstChild; D; D = D.nextSibling) {
				if (D.nodeType == 1) {
					t(D, ar)
				}
			}
		}
	}
	function ap(D, aw, ar) {
		D = al(D, {
			fps: 50,
			len: 15,
			onUpdate: ad,
			onStop: ad
		});
		if (j) {
			D.len = Math.round(D.len / 2)
		}
		function at(aA, az, ax, ay) {
			return ay ? ax + aA * (az - ax) : az + aA * (ax - az)
		}
		function av() {
			if (aw) {
				P()
			}
			ar = 0;
			aw = setInterval(au, 1000 / D.fps)
		}
		function P() {
			if (aw) {
				clearInterval(aw);
				aw = null
			}
			D.onStop(ar / D.len, at)
		}
		function au() {
			var ax = D.len;
			D.onUpdate(ar / ax, at);
			if (ar == ax) {
				P()
			}++ar
		}
		av();
		return {
			start: av,
			stop: P,
			update: au,
			args: D,
			map: at
		}
	}
	var Z = {
		elastic_b: function (D) {
			return 1 - Math.cos(-D * 5.5 * Math.PI) / Math.pow(2, 7 * D)
		},
		magnetic: function (D) {
			return 1 - Math.cos(D * D * D * 10.5 * Math.PI) / Math.exp(4 * D)
		},
		accel_b: function (D) {
			D = 1 - D;
			return 1 - D * D * D * D
		},
		accel_a: function (D) {
			return D * D * D
		},
		accel_ab: function (D) {
			D = 1 - D;
			return 1 - Math.sin(D * D * Math.PI / 2)
		},
		accel_ab2: function (D) {
			return (D /= 0.5) < 1 ? 1 / 2 * D * D : -1 / 2 * ((--D) * (D - 2) - 1)
		},
		brakes: function (D) {
			D = 1 - D;
			return 1 - Math.sin(D * D * Math.PI)
		},
		shake: function (D) {
			return D < 0.5 ? -Math.cos(D * 11 * Math.PI) * D * D : (D = 1 - D, Math.cos(D * 11 * Math.PI) * D * D)
		}
	};
	function am(D, P) {
		if (P === "") {
			j ? D.style.filter = "" : D.style.opacity = ""
		} else { if (P != null) {
				j ? D.style.filter = "alpha(opacity=" + P * 100 + ")" : D.style.opacity = P
			} else { if (!j) {
					P = parseFloat(D.style.opacity)
				} else { if (/alpha\(opacity=([0-9.])+\)/.test(D.style.opacity)) {
						P = parseFloat(RegExp.$1) / 100
					}
				}
			}
		}
		return P
	}
	function O(ar, D) {
		var P = ar.style;
		if (D != null) {
			P.display = D ? "" : "none"
		}
		return P.display != "none"
	}
	function f(P, ar) {
		var D = j ? P.clientX + document.body.scrollLeft : P.pageX;
		var at = j ? P.clientY + document.body.scrollTop : P.pageY;
		if (ar) {
			D -= ar.x;
			at -= ar.y
		}
		return {
			x: D,
			y: at
		}
	}
	function J(au) {
		var D = 0,
		at = 0,
		ar = /^div$/i.test(au.tagName),
		av,
		P;
		if (ar && au.scrollLeft) {
			D = au.scrollLeft
		}
		if (ar && au.scrollTop) {
			at = au.scrollTop
		}
		av = {
			x: au.offsetLeft - D,
			y: au.offsetTop - at
		};
		if (au.offsetParent) {
			P = J(au.offsetParent);
			av.x += P.x;
			av.y += P.y
		}
		return av
	}
	function X() {
		var P = document.documentElement,
		D = document.body;
		return {
			x: P.scrollLeft || D.scrollLeft,
			y: P.scrollTop || D.scrollTop,
			w: P.clientWidth || window.innerWidth || D.clientWidth,
			h: P.clientHeight || window.innerHeight || D.clientHeight
		}
	}
	function m(D, ar, P) {
		for (P = 0; P < D.length; ++P) {
			ar(D[P])
		}
	}
	var ad = new Function();
	function W(D) {
		if (typeof D == "string") {
			D = document.getElementById(D)
		}
		return D
	}
	return y
})();