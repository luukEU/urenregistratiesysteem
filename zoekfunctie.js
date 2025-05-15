function zoekInTabel() {
    var input, filter, table, tr, td, i, j, txtValue, rowVisible;
    input = document.getElementById("zoekveld");
    filter = input.value.toLowerCase();
    table = document.querySelector("table");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Sla de header over
        td = tr[i].getElementsByTagName("td");
        rowVisible = false;

        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    rowVisible = true;
                    break;
                }
            }
        }

        // Maak de rij zichtbaar of niet op basis van de zoekterm
        tr[i].style.display = rowVisible ? "" : "none";
    }
}
