document.addEventListener("DOMContentLoaded", function () {
    const searchBar = document.getElementById("searchBar");

    // Function to filter boxes
    function filterBoxes() {
        const searchTerm = searchBar.value.toLowerCase();
        const boxes = document.querySelectorAll(".box"); // Re-query all boxes on each search

        boxes.forEach(box => {
            const medName = box.querySelector(".med-name").innerText.toLowerCase();
            if (medName.includes(searchTerm)) {
                box.style.display = "block";
            } else {
                box.style.display = "none";
            }
        });
    }

    // Add event listener for input
    searchBar.addEventListener("input", filterBoxes);

    // Initial call to handle any pre-filled search term
    filterBoxes();
});