import { InitializeUI } from "./ui";
import { InitializeComponents } from "./components";
import { initializeMap } from "./map";

// IIFE (Immediately Invoked Function Expression) para encapsular o código
(() => {
    "use strict";

    // Função principal que inicializa todas as funcionalidades
    async function initializeApp() {
        initializeMap();
        InitializeUI();
        InitializeComponents();
    }

    // Executa a função principal quando o DOM estiver pronto
    document.addEventListener("DOMContentLoaded", () => {
        initializeApp();
    });
})();
