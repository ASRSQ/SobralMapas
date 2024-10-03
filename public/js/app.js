/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
// IIFE (Immediately Invoked Function Expression) para encapsular o código
(function () {
  "use strict";

  // Função para inicializar a sidebar
  function initializeSidebar() {
    var sidebar = document.getElementById("mainSidebar");
    var toggleButton = document.getElementById("toggleSidebar");
    toggleButton.addEventListener("click", function () {
      sidebar.classList.toggle("sidebar-collapsed");
    });
  }

  // Inicializa os tooltips do Bootstrap
  function initializeTooltip() {
    document.addEventListener("DOMContentLoaded", function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  }
  // Função para inicializar a pesquisa
  function initializeSearch() {
    var searchButton = document.getElementById("btn-search");
    var searchInput = document.querySelector(".input-search");
    searchButton.addEventListener("click", function () {
      searchInput.classList.toggle("hidden");
    });
  }

  // Função para alternar entre tela cheia (Fullscreen)
  function toggleFullScreen() {
    if (!document.fullscreenElement) {
      document.documentElement.requestFullscreen()["catch"](function (err) {
        console.log("Error attempting to enable full-screen mode: ".concat(err.message));
      });
    } else {
      document.exitFullscreen();
    }
  }

  // Função para inicializar o botão de expandir (fullscreen)
  function initializeExpandButton() {
    var expandButton = document.getElementById("btn-expand");
    var topBar = document.querySelector(".topbar");
    var mapEl = document.getElementById("map");
    expandButton.addEventListener("click", toggleFullScreen);

    // Alterna o ícone ao entrar e sair do modo fullscreen
    document.addEventListener("fullscreenchange", function () {
      var icon = expandButton.querySelector("i");
      if (document.fullscreenElement) {
        mapEl.style.height = "100vh";
        topBar.classList.add("hidden-topbar");
        icon.classList.remove("fa-expand-arrows-alt");
        icon.classList.add("fa-compress-arrows-alt"); // Ícone de "sair de tela cheia"
      } else {
        topBar.classList.remove("hidden-topbar");
        mapEl.style.height = "calc(100vh - 60px)";
        icon.classList.remove("fa-compress-arrows-alt");
        icon.classList.add("fa-expand-arrows-alt"); // Ícone de "expandir"
      }
    });
  }

  // Função para inicializar os toggles de camadas (checkboxes)
  function initializeLayerToggles(map) {
    var layer5Checkbox = document.getElementById("transol_linha_5");
    var layer6Checkbox = document.getElementById("transol_linha_6");

    // Listener para a camada Linha 5
    layer5Checkbox.addEventListener("change", function () {
      window.mapModule.toggleLayer(map, "transol_linha_5", this.checked);
    });

    // Listener para a camada Linha 6
    layer6Checkbox.addEventListener("change", function () {
      window.mapModule.toggleLayer(map, "transol_linha_6", this.checked);
    });
  }

  // Função para inicializar a caixa de seleção (mover e redimensionar)
  function initializeSelectionBox() {
    var selectionBox = document.getElementById("selection-box");
    var dragHandle = document.getElementById("drag-handle");
    var selectionButton = document.getElementById("selection-button");
    var selectionTools = document.querySelector(".selection-tools");
    var resolution = document.getElementById("resolution");
    var selectionArea = document.getElementById("selection-area");
    var isDragging = false;
    var startX, startY, offsetX, offsetY;

    // Verifica se os elementos estão presentes
    if (selectionButton && selectionTools) {
      selectionButton.addEventListener("click", function () {
        // Alterna a visibilidade da div "selection-tools"
        if (selectionTools.style.display === "none" || selectionTools.style.display === "") {
          selectionButton.classList.add("active");
          selectionTools.style.display = "block"; // Exibe o selection-tools
        } else {
          selectionTools.style.display = "none"; // Oculta o selection-tools
          selectionButton.classList.remove("active");
        }
      });
    }

    // Função para atualizar as dimensões no cabeçalho
    function updateDimensions() {
      var width = selectionArea.offsetWidth;
      var height = selectionArea.offsetHeight;
      resolution.innerHTML = "".concat(width, " x ").concat(height);
    }

    // Iniciar o arraste ao clicar no cabeçalho
    dragHandle.addEventListener("mousedown", function (e) {
      isDragging = true;
      startX = e.clientX;
      startY = e.clientY;

      // Pega a posição inicial da caixa de seleção
      offsetX = selectionBox.offsetLeft;
      offsetY = selectionBox.offsetTop;
      e.preventDefault(); // Previne seleção de texto
    });

    // Mover a caixa durante o arraste
    document.addEventListener("mousemove", function (e) {
      if (isDragging) {
        var moveX = e.clientX - startX;
        var moveY = e.clientY - startY;

        // Atualizar a posição da caixa de seleção
        selectionBox.style.left = offsetX + moveX + "px";
        selectionBox.style.top = offsetY + moveY + "px";
      }
    });

    // Finalizar o arraste ao soltar o mouse
    document.addEventListener("mouseup", function () {
      isDragging = false;
      updateDimensions(); // Atualiza as dimensões após o movimento
    });

    // Atualizar as dimensões quando a página carregar
    updateDimensions();

    // Função que escuta o redimensionamento da caixa
    var resizeObserver = new ResizeObserver(function () {
      updateDimensions(); // Atualiza as dimensões após o redimensionamento
    });

    // Observar mudanças na caixa de seleção
    resizeObserver.observe(selectionBox);
  }

  // Função para inicializar os botões da Action Bar que alterna entre seções dentro da sidebar
  function initializeActionButtons() {
    var btnCamadas = document.getElementById("btn-camadas");
    var btnMapasAtivos = document.getElementById("btn-mapas-ativos");
    var btnImpressao = document.getElementById("btn-imprimir");
    var selectionBox = document.getElementById("selection-box");
    btnImpressao.addEventListener("click", function () {
      // Alterna a visibilidade do componente
      if (selectionBox.style.display === "none" || selectionBox.style.display === "") {
        btnImpressao.classList.add("active");
        selectionBox.style.display = "flex"; // Exibe o componente
      } else {
        btnImpressao.classList.remove("active");
        selectionBox.style.display = "none"; // Oculta o componente
      }
    });
    btnCamadas.addEventListener("click", function () {
      // Exibe a div de Camadas e oculta a div de Mapas Ativos
      document.getElementById("view-camadas").style.display = "block";
      document.getElementById("view-mapas-ativos").style.display = "none";
      btnCamadas.classList.add("active");
      btnMapasAtivos.classList.remove("active");
    });
    btnMapasAtivos.addEventListener("click", function () {
      // Exibe a div de Mapas Ativos e oculta a div de Camadas
      document.getElementById("view-camadas").style.display = "none";
      document.getElementById("view-mapas-ativos").style.display = "block";
      btnMapasAtivos.classList.add("active");
      btnCamadas.classList.remove("active");
    });
  }
  function enableSwipeToDeleteAccordion(accordionId) {
    var items = document.querySelectorAll("#".concat(accordionId, " .accordion-item"));
    items.forEach(function (item) {
      var startX = 0;
      var currentX = 0;
      var threshold = 80; // Limiar para remover o item
      var isSwiping = false;
      var isMouseDown = false; // Flag para verificar se o mouse está pressionado
      var isMoving = false; // Flag para verificar se está havendo movimento
      var allowSwipe = false; // Flag para permitir o arraste
      var holdTimeout = null; // Timeout para contar os 5 segundos

      // Função para iniciar o arrasto
      function startSwipe(x) {
        startX = x;
        isSwiping = true;
        isMoving = false; // Resetar flag de movimento
      }

      // Função para processar o movimento
      function moveSwipe(x) {
        if (!isSwiping || !allowSwipe) return; // Só permitir o movimento se o arraste for autorizado
        currentX = x;
        var deltaX = currentX - startX;
        if (Math.abs(deltaX) > 10) {
          // Se houver movimento significativo, ativar a flag de movimento
          isMoving = true;
        }
        if (Math.abs(deltaX) > threshold && allowSwipe) {
          item.classList.add("layer-deleting");
        }
        if (deltaX < 0) {
          // Apenas seguir o arraste para a esquerda
          item.style.transform = "translateX(".concat(deltaX, "px)");
        }
      }

      // Função para finalizar o arrasto
      function endSwipe() {
        if (isMoving) {
          var deltaX = currentX - startX;
          if (Math.abs(deltaX) > threshold && allowSwipe) {
            // Se o arraste for maior que o limiar, remova o item
            item.style.transition = "transform 0.3s ease";
            item.style.transform = "translateX(-100%)";
            setTimeout(function () {
              item.remove(); // Remove o item após a animação
            }, 300);
          } else {
            // Volta ao estado original se o arraste for muito pequeno ou se não foi autorizado
            item.style.transition = "transform 0.3s ease";
            item.style.transform = "translateX(0)";
            item.classList.remove("layer-deleting");
          }
        }
        isMoving = false;
        isSwiping = false;
        isMouseDown = false;
        allowSwipe = false; // Reseta o estado para a próxima vez
      }

      // Inicia o temporizador de 5 segundos ao pressionar o botão
      function startHold() {
        holdTimeout = setTimeout(function () {
          allowSwipe = true; // Permitir o arraste após 5 segundos
          //item.classList.add("layer-deleting");
        }, 500); // Aguardar 5 segundos
      }

      // Cancela o temporizador se o mouse ou o dedo for solto antes dos 5 segundos
      function cancelHold() {
        clearTimeout(holdTimeout); // Cancela o timeout se o mouse for solto antes de 5 segundos
      }

      // Eventos para mobile
      item.addEventListener("touchstart", function (e) {
        startHold(); // Inicia o temporizador de 5 segundos
        startSwipe(e.touches[0].clientX);
      });
      item.addEventListener("touchmove", function (e) {
        moveSwipe(e.touches[0].clientX);
      });
      item.addEventListener("touchend", function (e) {
        cancelHold(); // Cancela o temporizador se o arrasto for interrompido
        if (isMoving) {
          endSwipe();
        }
      });

      // Eventos para desktop (mouse)
      item.addEventListener("mousedown", function (e) {
        isMouseDown = true;
        startHold(); // Inicia o temporizador de 5 segundos
        startSwipe(e.clientX);
      });
      item.addEventListener("mousemove", function (e) {
        if (!isMouseDown) return; // Apenas mover se o mouse estiver pressionado
        moveSwipe(e.clientX);
      });
      item.addEventListener("mouseup", function (e) {
        cancelHold(); // Cancela o temporizador se o arrasto for interrompido
        if (isMoving) {
          endSwipe();
        } else {
          isMouseDown = false;
          isSwiping = false;
          allowSwipe = false;
        }
      });
      item.addEventListener("mouseleave", function () {
        cancelHold(); // Cancela o temporizador se o mouse sair do item
        if (isMouseDown && isMoving) {
          endSwipe();
        }
      });
    });
  }
  function initializeFloatingButton() {
    var floatingButton = document.getElementById("floating-button");
    function dragElement(el) {
      var pos1 = 0,
        pos2 = 0,
        pos3 = 0,
        pos4 = 0;
      el.onmousedown = function (e) {
        // Verifica se o alvo do clique é um dropdown ou select
        if (e.target.closest('.dropdown-menu') || e.target.closest('select')) {
          return; // Não permite arrastar
        }
        e.preventDefault();
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
      };
      function elementDrag(e) {
        e.preventDefault();
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        el.style.top = el.offsetTop - pos2 + "px";
        el.style.left = el.offsetLeft - pos1 + "px";
      }
      function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
      }
    }

    // Ativando a funcionalidade de arraste no botão flutuante
    if (floatingButton) {
      dragElement(floatingButton);
    }
  }
  function initializeMeasure() {
    var draw;
    var sketch;
    var helpTooltipElement;
    var measureTooltipElement;
    var measureTooltip;
    var helpTooltip;
    var selectedLineColor = '#ffcc33'; // Cor padrão da linha e bolinha
    var selectedLineWidth = 2; // Largura padrão

    // Elementos HTML
    var measureLineButton = document.getElementById('measure-line');
    var measureAreaButton = document.getElementById('measure-area');
    var lineColorPicker = document.getElementById('line-color-picker');
    var lineWidthPicker = document.getElementById('line-width-picker');
    var lineWidthValue = document.getElementById('line-width-value');
    var clearDrawingsButton = document.getElementById('clear-drawings');
    var stopDrawingButton = document.getElementById('stop-drawing');
    var source = new ol.source.Vector({
      wrapX: false
    });

    // Camada de vetor para as geometrias
    var vectorLayer = new ol.layer.Vector({
      source: source,
      style: function style(feature) {
        return new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: selectedLineColor,
            width: 2
          }),
          fill: new ol.style.Fill({
            color: hexToRGBA(selectedLineColor, 0.4) // Cor preenchida semi-transparente
          }),
          image: new ol.style.Circle({
            radius: 5,
            fill: new ol.style.Fill({
              color: selectedLineColor // Cor da bolinha
            }),
            stroke: new ol.style.Stroke({
              color: '#000000',
              width: 1
            })
          })
        });
      }
    });
    window.map.addLayer(vectorLayer);

    // Converte hexadecimal para RGBA
    function hexToRGBA(hex, alpha) {
      var r = parseInt(hex.slice(1, 3), 16);
      var g = parseInt(hex.slice(3, 5), 16);
      var b = parseInt(hex.slice(5, 7), 16);
      return "rgba(".concat(r, ", ").concat(g, ", ").concat(b, ", ").concat(alpha, ")");
    }

    // Atualiza a cor da linha e do polígono com base no seletor de cor
    function updateLineColor(color) {
      selectedLineColor = color;
      vectorLayer.setStyle(function (feature) {
        return new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: selectedLineColor,
            width: 2
          }),
          fill: new ol.style.Fill({
            color: hexToRGBA(selectedLineColor, 0.4) // Preenchimento semi-transparente
          }),
          image: new ol.style.Circle({
            radius: 5,
            fill: new ol.style.Fill({
              color: selectedLineColor // Bolinha com a cor atual
            }),
            stroke: new ol.style.Stroke({
              color: '#000000',
              width: 1
            })
          })
        });
      });
    }

    // Define o tipo de desenho (linha ou polígono)
    function setDrawType(type) {
      if (draw) {
        window.map.removeInteraction(draw);
      }
      draw = new ol.interaction.Draw({
        source: source,
        type: type,
        style: function style(feature) {
          return new ol.style.Style({
            stroke: new ol.style.Stroke({
              color: selectedLineColor,
              width: 2,
              lineDash: [10, 10]
            }),
            fill: new ol.style.Fill({
              color: hexToRGBA(selectedLineColor, 0.4) // Preenchimento semi-transparente durante o desenho
            }),
            image: new ol.style.Circle({
              radius: 5,
              fill: new ol.style.Fill({
                color: selectedLineColor // Cor da bolinha
              }),
              stroke: new ol.style.Stroke({
                color: '#000000',
                width: 1
              })
            })
          });
        }
      });
      window.map.addInteraction(draw);
      createMeasureTooltip();
      createHelpTooltip();
      draw.on('drawstart', function (evt) {
        sketch = evt.feature;
        var tooltipCoord = evt.coordinate;
        sketch.getGeometry().on('change', function (evt) {
          var geom = evt.target;
          var output;
          if (geom instanceof ol.geom.Polygon) {
            output = "<span>".concat(formatArea(geom), "</span>");
            tooltipCoord = geom.getInteriorPoint().getCoordinates();
          } else if (geom instanceof ol.geom.LineString) {
            output = "<span>".concat(formatLength(geom), "</span>");
            tooltipCoord = geom.getLastCoordinate();
          }
          measureTooltipElement.innerHTML = output;
          measureTooltip.setPosition(tooltipCoord);
        });
      });
      draw.on('drawend', function () {
        sketch.setStyle(new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: selectedLineColor,
            width: 2,
            lineDash: null
          }),
          fill: new ol.style.Fill({
            color: hexToRGBA(selectedLineColor, 0.4) // Preenchimento após o desenho
          }),
          image: new ol.style.Circle({
            radius: 5,
            fill: new ol.style.Fill({
              color: selectedLineColor
            }),
            stroke: new ol.style.Stroke({
              color: '#000000',
              width: 1
            })
          })
        }));
        measureTooltipElement.className = 'ol-tooltip ol-tooltip-static';
        measureTooltip.setOffset([0, -7]);
        sketch = null;
        measureTooltipElement = null;
        createMeasureTooltip();
      });
    }

    // Criação dos tooltips de ajuda e medição
    function createHelpTooltip() {
      if (helpTooltipElement) {
        helpTooltipElement.remove();
      }
      helpTooltipElement = document.createElement('div');
      helpTooltipElement.className = 'ol-tooltip hidden';
      helpTooltip = new ol.Overlay({
        element: helpTooltipElement,
        offset: [15, 0],
        positioning: 'center-left'
      });
      window.map.addOverlay(helpTooltip);
    }
    function createMeasureTooltip() {
      if (measureTooltipElement) {
        measureTooltipElement.remove();
      }
      measureTooltipElement = document.createElement('div');
      measureTooltipElement.className = 'ol-tooltip ol-tooltip-measure';
      measureTooltip = new ol.Overlay({
        element: measureTooltipElement,
        offset: [0, -15],
        positioning: 'bottom-center',
        stopEvent: false,
        insertFirst: false
      });
      window.map.addOverlay(measureTooltip);
    }

    // Formata área e comprimento
    function formatArea(polygon) {
      var area = ol.sphere.getArea(polygon);
      return area > 10000 ? "".concat(Math.round(area / 1000000 * 100) / 100, " km\xB2") : "".concat(Math.round(area * 100) / 100, " m\xB2");
    }
    function formatLength(line) {
      var length = ol.sphere.getLength(line);
      return length > 100 ? "".concat(Math.round(length / 1000 * 100) / 100, " km") : "".concat(Math.round(length * 100) / 100, " m");
    }

    // Limpa todas as geometrias desenhadas e tooltips
    function clearDrawings() {
      source.clear();
      window.map.getOverlays().getArray().slice().forEach(function (overlay) {
        if (overlay.getElement().classList.contains('ol-tooltip')) {
          window.map.removeOverlay(overlay);
        }
      });
      if (measureTooltipElement) {
        measureTooltipElement.innerHTML = '';
      }
      if (helpTooltipElement) {
        helpTooltipElement.classList.add('hidden');
      }
      createMeasureTooltip();
      createHelpTooltip();
    }

    // Eventos para definir o tipo de medição
    measureLineButton.addEventListener('click', function (event) {
      event.preventDefault();
      setDrawType('LineString');
    });
    measureAreaButton.addEventListener('click', function (event) {
      event.preventDefault();
      setDrawType('Polygon');
    });

    // Atualiza a cor conforme a escolha do usuário
    lineColorPicker.addEventListener('input', function () {
      updateLineColor(this.value);
    });
    clearDrawingsButton.addEventListener('click', function () {
      clearDrawings();
    });

    // Adiciona um evento para o botão que para o desenho
    stopDrawingButton.addEventListener('click', function (event) {
      event.preventDefault();
      if (draw) {
        window.map.removeInteraction(draw);
        draw = null; // Limpa a variável draw para que não haja referências pendentes
      }
    });
  }

  // Função principal que inicializa todas as funcionalidades
  function initializeApp() {
    return _initializeApp.apply(this, arguments);
  } // Executa a função principal quando o DOM estiver pronto
  function _initializeApp() {
    _initializeApp = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
      var map;
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            map = window.mapModule.initializeMap(); // Inicializa o mapa chamando a função do `map.js`
            // Variaveis e metodos globais
            window.map = map;
            // initializePrintButton(map);
            initializeSidebar(); // Inicializa a funcionalidade da sidebar
            initializeSelectionBox();
            initializeSearch(); // Inicializa a funcionalidade da pesquisa
            initializeExpandButton(); // Inicializa a funcionalidade do Fullscreen
            initializeTooltip(); // Inicializa a funcionalidade dos tooltips das actions button na sidebar
            initializeActionButtons();
            initializeFloatingButton();
            initializeMeasure();
            enableSwipeToDeleteAccordion("accordionMapasAtivos");
            initializeLayerToggles(map); // Inicializa os toggles de camadas
            window.mapModule.loadSobralBoundary(map); // Demarca o espaço geográfico de sobral chamando a funcao do map.js
          case 13:
          case "end":
            return _context.stop();
        }
      }, _callee);
    }));
    return _initializeApp.apply(this, arguments);
  }
  document.addEventListener("DOMContentLoaded", function () {
    initializeApp();
  });
})();

/***/ }),

/***/ "./resources/css/custom.css":
/*!**********************************!*\
  !*** ./resources/css/custom.css ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/custom": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/custom"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/custom"], () => (__webpack_require__("./resources/css/custom.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;