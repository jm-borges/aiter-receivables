const createSupplierCheckbox = document.getElementById('create_supplier');
const supplierSelect = document.getElementById('supplier_id');

// Desabilita o select se o checkbox estiver marcado ao carregar a página
if (createSupplierCheckbox.checked) {
    supplierSelect.disabled = true;
}

// Escuta mudanças no checkbox
createSupplierCheckbox.addEventListener('change', function () {
    supplierSelect.disabled = this.checked;
});