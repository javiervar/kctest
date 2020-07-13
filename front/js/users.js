$(document).ready(function () {
    GetData(0);
});


function GetData(page) {
    var params = {
        page: page
    }

    $.ajax({
        
        url: "../api/src/users.php",
        data: params,
        cache: false,
        success: function (data) {
            var data = JSON.parse(data);
            //If user does not logged in redirect to login page
            if (data.error) {
                window.location.href = "index.html";
                return;
            }
            var users = data.data;
            var row = '';
            for (var i in users) {
                row += `<div class="row usr-row">
                <div class="col column"><div class="column-name"> <img src="img/correct.png" alt=""> 
                <div><p class="row-user">${users[i].user_name}</p> 
                <p class="row-name">${users[i].first_name} ${users[i].last_name}</p> </div></div></div><div class="col column"> <div class="column-desc"> <div><a href="#">...</a> 
                <p>Group</p></div></div></div></div>`;
            }
            $("#table_content").html(row)
            var page_num = "";
            for (var x = 0; x < data.total_pages; x++) {
                if (page == x) {
                    page_num += `<a href="#" class="pag-n active" onclick="GetData(${x})">${x + 1}</a>`;
                } else {
                    page_num += `<a href="#" class="pag-n" onclick="GetData(${x})">${x + 1}</a>`;
                }

            }
            if ((page + 1) == data.total_pages) {
                page_num += `<a href="#" class="pag-n">Next >></a>`;
            } else {
                page_num += `<a href="#" class="pag-n" onclick="next(${page})">Next >></a>`;
            }

            $("#pagination").html(page_num);
        }
    });

}


function next(currentPage) {
    GetData(currentPage + 1);
}

function logout() {
    $.ajax({
        type: "DELETE",
        url: "../api/src/auth.php",
        cache: false,
        success: function (data) {
            window.location.href = "index.html";
        }
    });
}
