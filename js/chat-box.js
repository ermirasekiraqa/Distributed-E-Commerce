let chatboxButton = document.getElementById("chatbox-button");
// chatboxButton.addEventListener("click", function() {
//     // console.log('here');
//     // closeChat();
// });
chatboxButton.addEventListener("click", new openChat(socket));

// function openAndCloseChat() {
//         chatboxButton.addEventListener("click", closeChat);
//         chatboxButton.addEventListener("click", openChat);
// }

// function openChat() {
//     displayChat();
//     chatboxButton.addEventListener("click", openAndCloseChat);
// }

// function closeChat() {
//     let chatContainer = document.getElementById("chatbox-support");
//     chatContainer.innerHTML = ""; 
// }

function openChat(socket) {
    // const socket = io();

    socket.on("connect", () => {
        console.log("Connected to server");
    });

    // socket.on("message", (data) => {
    //     console.log("Received message:", data);
    // });

    // socket.emit("chatMessage", "Hello, server!");
}

function displayChat() {
    let chatContainer = document.getElementById("chatbox-support");
    chatContainer.append(createChatboxHeader());
    chatContainer.append(createChatBoxMessages());
    chatContainer.append(createChatBoxInput());

    // chatboxButton = document.getElementById("chatbox-button");
    // chatboxButton.addEventListener("click", function() {
    //     // console.log('here');
    //     // displayChat();
    //     closeChat();
    // });
}

function createChatboxHeader() {
    // Create the div element with class "chatbox-image-header"
    const imageDiv = document.createElement("div");
    imageDiv.className = "chatbox-image-header";

    // Create the image element
    const image = document.createElement("img");
    image.src = "https://img.icons8.com/color/48/000000/circled-user-female-skin-type-5--v1.png";
    image.alt = "image";

    // Append the image to the div
    imageDiv.appendChild(image);

    // Create the div element with class "chatbox-content-header"
    const contentDiv = document.createElement("div");
    contentDiv.className = "chatbox-content-header";

    // Create the heading element
    const heading = document.createElement("h4");
    heading.className = "chatbox-heading-header";
    heading.textContent = "Chat support";

    // Create the description paragraph element
    const description = document.createElement("p");
    description.className = "chatbox-description-header";
    description.textContent = "How can we help you?";

    // Append the heading and description to the content div
    contentDiv.appendChild(heading);
    contentDiv.appendChild(description);

    // Create a container div to hold the image and content div
    const containerDiv = document.createElement("div");
    containerDiv.appendChild(imageDiv);
    containerDiv.appendChild(contentDiv);

    // Return the container div
    return containerDiv;
}

function createChatBoxMessages() {
    // Create the div element with class "chatbox-messages"
    const messagesDiv = document.createElement("div");
    messagesDiv.className = "chatbox-messages";

    const messages = document.createElement("div");
    messages.className = "messages-container";

    messagesDiv.appendChild(messages);

    return messagesDiv;
}

function createChatBoxInput() {
    // Create the div element with class "chatbox-input"
    const chatboxInputContainer = document.createElement("div");
    chatboxInputContainer.className = "chatbox-input";

    // Create input element
    const chatboxInput = document.createElement("input");
    chatboxInput.type = "text";
    chatboxInput.placeholder = "Write a message...";

    // Create send button
    const chatboxButton = document.createElement("button");
    chatboxButton.className = "chatbox-send-footer send-button";
    chatboxButton.innerText = "Send";

    // Add input and button to chatboxInputContainer
    chatboxInputContainer.append(chatboxInput);
    chatboxInputContainer.append(chatboxButton);

    return chatboxInputContainer;
}
