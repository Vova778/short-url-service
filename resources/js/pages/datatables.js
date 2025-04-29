import $ from 'jquery';
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';


export default function initDataTables(selector = '#links-table') {
  $(document).ready(() => {
    $(selector).DataTable({
      paging: true,
      ordering: true,
      info: true,
    });
  });
}

initDataTables('#links-table');
