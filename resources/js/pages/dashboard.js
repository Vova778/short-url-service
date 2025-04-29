import $ from "jquery";

import "datatables.net-bs5";
import "datatables.net-responsive-bs5";

import "datatables.net-buttons-bs5";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print";

import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css";
import "datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css";

import "daterangepicker";
import "daterangepicker/daterangepicker.css";

import Swal from "sweetalert2";

$(function () {
    const table = $("#linksTable").DataTable({
        responsive: true,
        lengthChange: false,
        pageLength: 10,
        buttons: ["copy", "csv", "excel", "print"],
        dom: "Bfrtip",
        columnDefs: [
            { orderable: false, targets: -1 },
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "🔍 Search...",
        },
    });

    table.buttons().container().appendTo("#linksTable_wrapper .col-md-6:eq(0)");
    
    $("#applyFilter").on("click", function () {
        const [start, end] = $("#dateRange").val().split(" - ");
        $.fn.dataTable.ext.search.push((settings, data) => {
            const expires = data[3].trim() === "Never" ? null : data[3];
            return (
                !expires || moment(expires).isBetween(start, end, null, "[]")
            );
        });
        table.draw();
        $.fn.dataTable.ext.search.pop();
    });

    $("#linksTable").on("click", ".delete-btn", function () {
        const form = $(this).next("form");
        Swal.fire({
            title: "Are you sure?",
            text: "You won’t be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
