function addMessage(text, sender) {
    const box = document.getElementById("chat-box");

    const msg = document.createElement("div");
    msg.classList.add("chat-message");

    if (sender === "user") {
        msg.classList.add("user-message");
    } else {
        msg.classList.add("bot-message");
    }

    msg.innerText = text;
    box.appendChild(msg);

    // Tự động scroll xuống cuối
    box.scrollTop = box.scrollHeight;
}


async function sendMessage() {
    const input = document.getElementById("user-input");
    const text = input.value.trim();

    if (!text) return;

    addMessage(text, "user");
    input.value = "";

    const res = await fetch("/chatbox-giadv/api_proxy.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text })
    });

    const data = await res.json();
    addMessage(data.answer, "bot");
}



function appendMsg(sender, text) {
    let box = document.getElementById("chat-box");
    let msg = document.createElement("div");

    msg.className = sender === "user" ? "msg-user" : "msg-bot";
    msg.textContent = text;

    box.appendChild(msg);
    box.scrollTop = box.scrollHeight;
}

// Gửi bằng nút Enter
document.getElementById("user-input").addEventListener("keypress", function(e) {
    if (e.key === "Enter") sendMessage();
});
