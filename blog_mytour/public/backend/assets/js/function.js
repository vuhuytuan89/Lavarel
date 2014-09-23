function onCheckAll() {
    var check = document.getElementsByName('chkMasCheck');
    var items = document.getElementsByName('chk');
    if (check[0].checked == true) {
        for (var i = 0; i < items.length; i++) {
            items[i].checked = true;
        }
    } else {
        for (var i = 0; i < items.length; i++) {
            items[i].checked = false;
        }
    }
}

function onDelAll(_dr) {
    var items = document.getElementsByName('chk');
    var arr = '';
    for (var i = 0; i < items.length; i++) {
        if (items[i].checked == true) {
            arr += items[i].value + ",";
        }
    }
    if (arr.length == 0) {
        alert("Bạn chưa chọn trường cần xóa");
    }
    if (arr.length == 1) {
        var listId = arr.substring(0, arr.length - 1);
        if (confirm("Xóa?")) {
            window.location.href = _dr + listId;
        }
    }
    if (arr.length > 1) {
        var listId = arr.substring(0, arr.length - 1);
        if (confirm("Xóa?")) {
            window.location.href = _dr + listId;
        }
    }
}