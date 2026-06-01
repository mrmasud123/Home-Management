
import { marked } from "marked";

const CONFIG = {
    formId: "#form",
    messageBoxId: "#userMessageBox",
    promptId: "#prompt",
    submitBtn: 'button[type="submit"]',
    scrollSpeed: 200,
};

const State = {
    aiIdTrace: 1,

    nextId() {
        return this.aiIdTrace++;
    },
};

const Templates = {
    welcomeMessage() {
        return `
<div class="flex items-start gap-4 justify-start mb-6">
    <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-semibold shadow-md">
    AI
    </div>

<div class="bg-white border border-slate-200 rounded-3xl rounded-tl-sm px-5 py-4 shadow-sm">
                    <span class="text-slate-700">
                        Hello! How can I help you today?
                    </span>
</div>
</div>
`;
    },

    userMessage(text) {
        return `
<div class="flex justify-end gap-3 mb-6">

    <div class="bg-blue-600 text-white rounded-3xl px-5 py-3 max-w-[75%] shadow-md">
    ${$("<div>").text(text).html()}
</div>

<div class="w-10 h-10 rounded-2xl bg-slate-200 text-slate-700 flex items-center justify-center font-medium">
    U
</div>

</div>
`;
    },

    aiThinking(id) {
        return `
<div class="flex items-start gap-4 justify-start mb-6">

    <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-semibold shadow-md shrink-0">
    AI
    </div>

<div
    id="aiChatBox${id}"
    class="bg-white border border-slate-200 rounded-3xl rounded-tl-sm px-5 py-4 shadow-sm max-w-[80%]">

    <div class="flex items-center gap-2">

                        <span class="text-slate-600">
                            AI is thinking
                        </span>

        <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce"></span>

        <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>

        <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>

    </div>

</div>

</div>
`;
    },
};

const UI = {
    messageBox: null,
    form: null,

    init() {
        this.messageBox = $(CONFIG.messageBoxId);
        this.form = $(CONFIG.formId);
    },

    append(html) {
        this.messageBox.append(html);
    },

    scrollToBottom() {
        this.messageBox.animate(
            {
                scrollTop: this.messageBox[0].scrollHeight,
            },
            CONFIG.scrollSpeed
        );
    },

    setAiResponse(id, text) {
        const html = marked.parse(text);

        $(`#aiChatBox${id}`).html(`
<div class="prose prose-sm max-w-none text-slate-700">
    ${html}
</div>
`);
    },

    setAiError(id, message) {
        $(`#aiChatBox${id}`).html(`
<div class="text-red-500">
    ${message}
</div>
`);
    },

    disableSubmit() {
        this.form.find(CONFIG.submitBtn).prop("disabled", true);
    },

    enableSubmit() {
        this.form.find(CONFIG.submitBtn).prop("disabled", false);
    },

    clearPrompt() {
        $(CONFIG.promptId).val("");
    },
};

const API = {
    setup() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    },

    send(url, formData, onSuccess, onError) {
        $.ajax({
            url,
            method: "POST",
            data: formData,
            beforeSend: () => UI.disableSubmit(),
            complete: () => UI.enableSubmit(),
            success: onSuccess,
            error: onError,
        });
    },
};

const Chat = {
    handleSubmit(e) {
        e.preventDefault();

        const prompt = $(CONFIG.promptId).val().trim();

        if (!prompt) {
            return;
        }

        const formData = UI.form.serialize();
        const aiId = State.nextId();

        UI.append(Templates.userMessage(prompt));
        UI.append(Templates.aiThinking(aiId));

        UI.clearPrompt();
        UI.scrollToBottom();

        API.send(
            UI.form.attr("action"),
            formData,
            (response) => Chat.onSuccess(aiId, response),
            (xhr) => Chat.onError(aiId, xhr)
        );
    },

    onSuccess(aiId, response) {
        const text = response?.received ?? JSON.stringify(response);

        UI.setAiResponse(aiId, text);
        UI.scrollToBottom();
    },

    onError(aiId, xhr) {
        let errorMsg = "Something went wrong. Please try again.";

        if (xhr.responseJSON?.errors) {
            errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
        } else if (xhr.responseJSON?.message) {
            errorMsg = xhr.responseJSON.message;
        }

        console.error(xhr);

        UI.setAiError(aiId, errorMsg);
        UI.scrollToBottom();
    },
};

$(document).ready(function () {
    UI.init();
    API.setup();

    UI.append(Templates.welcomeMessage());

    UI.form.on("submit", function (e) {
        Chat.handleSubmit(e);
    });
});
