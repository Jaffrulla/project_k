function card_insert(item_name,price,img,desc,reviews_present,cur_rate){
    var division  = document.createElement('li');
    const att = document.createAttribute("class");
    const att2 = document.createAttribute("name");
    att.value = "listed";
    att2.value = item_name;
    division.setAttributeNode(att);
    division.setAttributeNode(att2);
    cur_rate = parseFloat(`${cur_rate}`);
    //alert(cur_rate);
    var dec = cur_rate;
    cur_rate = cur_rate * 20;
    var temp = cur_rate % 10;
    cur_rate = cur_rate - temp;
    if(temp >= 5){
        cur_rate = cur_rate + 10;
    }
    //alert(`${temp},${cur_rate},${dec}`);
    if(desc=='none'){
        desc = '';
    }
    var code = `<div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="../css/item_uploads/${img}" alt="Restaurant Image" class="img-responsive">
                    </div>
    
                    <div class="food-menu-desc">
                        <h4>${item_name}</h4>
                        <p class="food-price">Rs.${price}</p>
                        <span class='rate_val'><p class="stars-container stars-${cur_rate}">★★★★★</p>${dec}<span>
                        <p class="food-detail">
                        ${desc}
                        
                        <span id='star_rating${item_name}'><pre><br></pre></span>
                        </p>
                        <span id="submit_rating${item_name}"><button class="btn" onclick="return get_reviews('${item_name}','${reviews_present}')">Reviews</button></span>
                    </div>
                </div>`;
    division.innerHTML = code;
    var element = document.getElementById('dynamic_res');
    element.appendChild(division);
    }



function get_reviews(item_name,reviews_present){
    var sub = document.getElementById('star_rating'+item_name);
    if(reviews_present=='none'){
        sub.innerHTML = `<div class="rev_box ${item_name}" id="rev_box${item_name}">
                    <p>No Reviews Yet</p>
        </div>`;
    }
    else{
    sub.innerHTML = `
                    <div class="rev_box rev_box_${item_name}" id="rev_box_${item_name}">
                    <span id='records${item_name}'></span>
                    </div>
                    
                    `;
    var par = document.getElementById(`records${item_name}`);
    var rev_array = reviews_present.split('<>');
    for(var i = 1; i<rev_array.length;i++){
        var element = document.createElement('div');
        element.setAttribute('id',`rev_card_${item_name}`);
        // element.setAttribute('style','background-color: rgb(255, 255, 255);');
        element.classList.add(`rev_card_${item_name}`);
        element.classList.add(`rev_card`);
        var parts = rev_array[i].split('~~');
        var user = parts[0];
        var date = parts[1];
        var rev = parts[2];
        var rate = parts[3];
        var code = `
        <span class="stars-container stars-${rate*20}">★★★★★</span>
        <p class=''rev_desc>${rev}</p><br>
        <p class='rev_details'>-BY ${user} on ${date}</p><br>
        `;
        element.innerHTML = code;
        par.appendChild(element);
        
    }
}
var but = document.getElementById('submit_rating'+item_name);
but.innerHTML = `<button class="btn" onclick="return back('${item_name}','${reviews_present}')">Back</button>`;

}

function back(item_name,reviews_present){
    var rating = document.getElementById('star_rating'+item_name);
    var sub = document.getElementById('submit_rating'+item_name);
    rating.innerHTML = "<pre><br></pre>";
    sub.innerHTML = `<button class="btn" onclick="return get_reviews('${item_name}','${reviews_present}')">Reviews</button>`;
}



function get_res_reviews(reviews_present){
    var sub = document.getElementById('get_res_reviews');
    if(reviews_present=='none'){
        sub.innerHTML = `<div class="rev_box2" id="rev_box">
                    <p>No Reviews Yet</p>
        </div>`;
    }
    else{
    sub.innerHTML = `
                    <div class="rev_box2" id="rev_box_">
                    <span id='records'></span>
                    </div>
                    
                    `;
    var par = document.getElementById(`records`);
    var rev_array = reviews_present.split('<>');
    for(var i = 1; i<rev_array.length;i++){
        var element = document.createElement('div');
        element.setAttribute('id',`rev_card_${i}`);
        // element.setAttribute('style','background-color: rgb(255, 255, 255);');
        element.classList.add(`rev_card2`);
        var parts = rev_array[i].split('~~');
        var user = parts[0];
        var date = parts[1];
        var rev = parts[2];
        var rate = parts[3];
        var code = `
        <span class="stars-container stars-${rate*20}">★★★★★</span>
        <p class='rev_desc'>${rev}</p><br>
        <p class='rev_details'>-BY ${user} on ${date}</p><br>
        `;
        element.innerHTML = code;
        par.appendChild(element);
        
    }
    }
    var back = document.getElementById('backing');
    back.innerHTML = `<br><br><button class="btn" onclick="return rev_back()">Back</button>`;
}

function rev_back(){
    location.herf = '';
    var sub = document.getElementById('get_res_reviews');
    sub.innerHTML = '';
    var but = document.getElementById('backing');
    but.innerHTML = `<br><br><button class="btn" onclick='location.href = "?show_reviews=1"'>Restaurant Reviews</button>`;
}