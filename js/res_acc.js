function card_insert(item_name,price,img,desc,reviews_present){
    var division  = document.createElement('li');
    const att2 = document.createAttribute("name");
    att2.value = item_name;
    division.setAttributeNode(att2);
    var code = `<div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="../css/item_uploads/${img}" alt="Restaurant Image" class="img-responsive">
                    </div>
    
                    <div class="food-menu-desc">
                        <h4>${item_name}</h4>
                        <p class="food-price">Rs.${price}</p>
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
                    <span id='records'></span>
                    </div>
                    
                    `;
    var par = document.getElementById('records');
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

