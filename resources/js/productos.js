function actualizarProductos(filters = null, search = null) {
    let url = "{{ route('productos.index') }}";
    
    if (filters && filters.length > 0) {
        url = "{{ route('productos.filtrar') }}";
    } else if (search) {
        url = "{{ route('productos.buscar') }}";
    }

    $.ajax({
        url: url,
        type: 'GET',
        data: {
            filters: filters,
            search: search
        },
        success: function(response) {
            if (response.html) {
                $('#product-list').empty().html(response.html);
                
                if (response.pagination) {
                    $('.pagination').html(response.pagination);
                }
                
                initializePlugins();
            } else {
                $('#product-list').html('<div class="col-12 text-center"><p>No se encontraron productos</p></div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#product-list').html('<div class="col-12 text-center"><p>Error al cargar los productos</p></div>');
        }
    });
}

// Manejador para el buscador
$('#search-input').on('keyup', function() {
    clearTimeout(typingTimer);
    const searchTerm = $(this).val();
    
    typingTimer = setTimeout(function() {
        actualizarProductos(null, searchTerm);
    }, doneTypingInterval);
});

// Manejador para los filtros
$('.filter-option').on('click', function(e) {
    e.preventDefault();
    const filter = $(this).data('filter');
    actualizarProductos([filter]);
});