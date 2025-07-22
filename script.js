document.getElementById("blogPostForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const title = document.getElementById("postTitle").value.trim();
    const content = document.getElementById("postContent").value.trim();

    if (!title || !content) {
        document.getElementById("blogStatus").textContent = "Please fill out all fields.";
        return;
    }

    // Simulate a successful post (replace with real API/database logic)
    console.log("New blog post:", { title, content });
    document.getElementById("blogStatus").textContent = "Post published!";
    this.reset();
});

//  SAVE DRAFT
document.getElementById("saveDraftBtn").addEventListener("click", function () {
    const title = document.getElementById("postTitle").value.trim();
    const content = document.getElementById("postContent").value.trim();

    if (!title && !content) {
        document.getElementById("blogStatus").textContent = "Nothing to save.";
        return;
    }

    const draft = {
        title,
        content,
        savedAt: new Date().toISOString()
    };

    localStorage.setItem("draftPost", JSON.stringify(draft));
    document.getElementById("blogStatus").textContent = "Draft saved!";
});

// Load Draft Automatically When Page Loads
window.addEventListener("DOMContentLoaded", () => {
    const savedDraft = JSON.parse(localStorage.getItem("draftPost"));
    if (savedDraft) {
        document.getElementById("postTitle").value = savedDraft.title;
        document.getElementById("postContent").value = savedDraft.content;
        document.getElementById("blogStatus").textContent = "Loaded saved draft.";
    }
});
