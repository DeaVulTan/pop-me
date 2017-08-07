jQuery( document ).ready(function() {
    jQuery( "#dynamic-table-orders" ).table_download({
        format: "xls",
        separator: ",",
        filename: "orders",
        linkname: "Export orders as XLS",
        quotes: "\""
    });
    
});


