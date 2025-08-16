document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("blogPostForm");
    const titleInput = document.getElementById("postTitle");
    const contentInput = document.getElementById("postContent");
    const statusInput = document.getElementById("postStatus");
    const blogStatus = document.getElementById("blogStatus");
    const saveDraftBtn = document.getElementById("saveDraftBtn");
    const clearDraftBtn = document.getElementById("clearDraftBtn");

    // ==== Load Draft on Page Load ====
    const savedDraft = JSON.parse(localStorage.getItem("draftPost"));
    if (savedDraft) {
        titleInput.value = savedDraft.title || '';
        contentInput.value = savedDraft.content || '';
        blogStatus.textContent = "Loaded saved draft.";
        blogStatus.className = "info";
    }

    // ==== Save Draft to localStorage + submit to server ====
    saveDraftBtn.addEventListener('click', function (event) {
        event.preventDefault(); // stop form from submitting immediately

        const title = titleInput.value.trim();
        const content = contentInput.value.trim();

        if (!title && !content) {
            blogStatus.textContent = "Nothing to save.";
            blogStatus.className = "info";
            return;
        }

        // Save to localStorage
        const draft = {
            title: title,
            content: content
        };
        localStorage.setItem("draftPost", JSON.stringify(draft));

        // Update hidden status field
        statusInput.value = 'draft';

        // Show feedback message
        blogStatus.textContent = "Draft saved!";
        blogStatus.className = "info";

        // Submit form after saving
        form.submit();
    });

    // ==== Clear Draft from localStorage ====
    clearDraftBtn.addEventListener('click', function () {
        localStorage.removeItem("draftPost");
        titleInput.value = '';
        contentInput.value = '';
        blogStatus.textContent = "Draft cleared.";
        blogStatus.className = "info";
    });

    // ==== Optional: On successful publish, clear localStorage too ====
    form.addEventListener('submit', function () {
        localStorage.removeItem("draftPost");
    });
});
