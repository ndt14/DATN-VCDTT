// Get the search input and table elements
const searchInput = document.getElementById("searchInput");
const userTable = document.getElementById("userTable");
const tableRows = userTable
  .getElementsByTagName("tbody")[0]
  .getElementsByTagName("tr");

searchInput.addEventListener("input", function () {
  const searchValue = searchInput.value.toLowerCase();

  for (let i = 0; i < tableRows.length; i++) {
    const row = tableRows[i];
    const rowData = row.getElementsByTagName("td");
    let foundMatch = false;

    for (let j = 0; j < rowData.length; j++) {
      const cell = rowData[j];
      if (cell.textContent.toLowerCase().indexOf(searchValue) > -1) {
        foundMatch = true;
        break;
      }
    }

    if (foundMatch) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  }
});

const searchButton = document.getElementById("button-addon2");
searchButton.addEventListener("click", function () {
  searchInput.dispatchEvent(new Event("input"));
});
