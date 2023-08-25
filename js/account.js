function card_insert(menu,res_name,contact,img,cur_rate){
var division  = document.createElement('li');
const att = document.createAttribute("class");
const att2 = document.createAttribute("name");
const att3 = document.createAttribute("name");
att.value = "listed";
att2.value = res_name;
att3.value = res_name;
division.setAttributeNode(att);
division.setAttributeNode(att2);
division.setAttributeNode(att3);
cur_rate = parseFloat(`${cur_rate}`);
var dec = cur_rate;
dec = Number((dec).toFixed(1));
cur_rate = cur_rate * 20;
var temp = cur_rate % 10;
cur_rate = cur_rate - temp;
if(temp >= 5){
    cur_rate = cur_rate + 10;
}
var code = `<div class="food-menu-box">
                <div class="food-menu-img">
                    <img src="../css/res_uploads/${img}" alt="Restaurant Image" class="img-responsive menu_img">
                </div>

                <div class="food-menu-desc">
                    <h4>${res_name}</h4>
                    <p class="food-price">Contact: ${contact}</p>
                    <span class='rate_val'><p class="stars-container stars-${cur_rate}">★★★★★ </p>${dec}<span>
                    <br>

                    <button name='redirect' class="btn" onclick='location.href = "?redirect=1&menu=${menu}&res_name=${res_name}"'>Check Out</button>
                </div>
            </div>`;
division.innerHTML = code;
var element = document.getElementById('dynamic_res');
element.appendChild(division);
}

/*
function anchor(temp){
    var menu = temp;
    '<%$_Session["menu"]="'+ menu +'";%>';
    window.location.href = 'display_menu.php';
}

function find(){
const searchInput = document.getElementById("search");

// store name elements in array-like object
const namesFromDOM = document.getElementsByClassName("listed");

// listen for user events
    const value = searchInput.value;
    
    // get user search input converted to lowercase
    const searchQuery = value.toLowerCase();
    for (const nameElement of namesFromDOM) {
        // store name text and convert to lowercase
        let name = nameElement;
        // compare current name to search input
        if (name.includes(searchQuery)) {
            // found name matching search, display it
            nameElement.style.display = "block";
        } else {
            // no match, don't display name
            nameElement.style.display = "none";
        }
    }
}
*/