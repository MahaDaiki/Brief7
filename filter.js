function filter_data(page) {
        var action = 'fetch_data';
        var category = get_filter('category');
        var searchQuery = document.getElementById('search').value.trim();
        var sortAlphabetically = document.getElementById('sort_alphabetically').checked;
        var stockFilter = document.getElementById('stock_filter').checked;
    
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_data.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // console.log(xhr.response);
                document.querySelector('.filter_data').innerHTML = xhr.responseText;
            }
        };
    
        var data = "action=" + action +
            "&category=" + JSON.stringify(category) +
            "&search_query=" + searchQuery +
            "&sort_alphabetically=" + (sortAlphabetically ? 1 : 0) +
            "&stock_filter=" + (stockFilter ? 1 : 0) +
            "&page=" + page;
        console.log(data);
        xhr.send(data);
    }
    
    function get_filter(class_name) {
        var filter = [];
        var checkboxes = document.querySelectorAll('.' + class_name + ':checked');
        checkboxes.forEach(function (checkbox) {
            filter.push(checkbox.value);
        });
    
        return filter;
    }
    
    document.getElementById('search').addEventListener('input', function () {
        filter_data(1); // Reset to the first page when searching
    });
    
    document.querySelectorAll('.common_selector').forEach(function (selector) {
        selector.addEventListener('change', function () {
            filter_data(1); // Reset to the first page when changing filters
        });
    });
    
    // Initial load
filter_data(1);    
    