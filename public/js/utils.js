// utils.js

// Função para gerar um ID único
function generateUniqueId() {
    const randomString = Math.random().toString(36).substring(2, 15);
    const data = `${latitude}_${longitude}_${randomString}`;

    return crypto.subtle
        .digest("SHA-256", new TextEncoder().encode(data))
        .then((hashBuffer) => {
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray
                .map((b) => b.toString(16).padStart(2, "0"))
                .join("");
            return `${latitude}_${longitude}_${hashHex}`;
        });
}
