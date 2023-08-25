function card_insert(item_name,price,img,desc,given,reviews_present,cur_rate){
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
    if(given){
        var button_code = 'Already Rated';
    }
    else{
        var button_code = `<button class="btn" onclick="return give_rating('${item_name}','${reviews_present}',${given})">Rate</button>`;
    }
    var code = `<div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="../css/item_uploads/${img}" alt="Restaurant Image" class="img-responsive menu_img">
                    </div>
    
                    <div class="food-menu-desc">
                        <h4>${item_name}</h4>
                        <p class="food-price">Rs.${price}</p>
                        <span class='rate_val'><p class="stars-container stars-${cur_rate}">★★★★★ </p>${dec}<span>
                        <p class="food-detail">
                        ${desc}
                        
                        <span id='star_rating${item_name}'><pre><br></pre></span>
                        </p>
                        <span id="submit_rating${item_name}">${button_code}<button class="btn" onclick="return get_reviews('${item_name}','${reviews_present}',${given})">Reviews</button></span>
                    </div>
                </div>`;
    division.innerHTML = code;
    var element = document.getElementById('dynamic_res');
    element.appendChild(division);
    }



function give_rating(item_name,reviews_present,given){
    var rating = document.getElementById('star_rating'+item_name);
    var sub = document.getElementById('submit_rating'+item_name);
    rating.innerHTML = `<div class="rating-css">
                        <form action="#" method="post" class="form-group">
                        <div class="star-icon">
                            <input type="radio" name="rating${item_name}" id="rating1${item_name}" value="1">
                            <label for="rating1${item_name}" >★</label>
                            <input type="radio" name="rating${item_name}" id="rating2${item_name}" value="2">
                            <label for="rating2${item_name}" >★</label>
                            <input type="radio" name="rating${item_name}" id="rating3${item_name}" value="3">
                            <label for="rating3${item_name}" >★</label>
                            <input type="radio" name="rating${item_name}" id="rating4${item_name}" value="4" checked>
                            <label for="rating4${item_name}" >★</label>
                            <input type="radio" name="rating${item_name}" id="rating5${item_name}" value="5">
                            <label for="rating5${item_name}" >★</label>
                            <br>
                        </div>
                        <textarea class="review_to_give" name="review${item_name}" id="review${item_name}" cols="25" rows="4" placeholder="Your Review"></textarea>
                        </form>
                        </div>`;
    
    sub.innerHTML = `<button class="btn" onclick="return submit_rating('${item_name}','${reviews_present}')">submit</button>
    <button class="btn" onclick="return back('${item_name}','${reviews_present}',${given})">Back</button>`;
}

function get_reviews(item_name,reviews_present,given){
   // alert(`'${reviews_present},${item_name}'`);
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
        //element.classList.add(`rev_card_${item_name}`);
        element.classList.add(`rev_card`);
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
var but = document.getElementById('submit_rating'+item_name);
if(given){
    var rate_code="Already Rated";
}
else{
    var rate_code = `<button class="btn" onclick="return give_rating('${item_name}','${reviews_present}',${false})">Rate</button>`;
}
but.innerHTML = `${rate_code}<br><button class="btn" onclick="return back('${item_name}','${reviews_present}',${given})">Back</button>`;

}

function back(item_name,reviews_present,given){
    var rating = document.getElementById('star_rating'+item_name);
    var sub = document.getElementById('submit_rating'+item_name);
    rating.innerHTML = "<pre><br></pre>";
    if(given){
        var rate_code = "Already Rated";
    }
    else{
        var rate_code = `<button class="btn" onclick="return give_rating('${item_name}','${reviews_present}',${false})">Rate</button>`;
    }
    sub.innerHTML = `${rate_code}
    <button class="btn" onclick="return get_reviews('${item_name}','${reviews_present}',${given})">Reviews</button>`;
}

function submit_rating(item_name,reviews_present){
    var star = document.getElementsByName(`rating${item_name}`);
    for(i=0;i<star.length;i++){
        if(star[i].checked){
            var star_value = star[i].value;
            break;
        }
    }
    var review = document.getElementById(`review${item_name}`).value;
    if(review==''){review='none';}
    location.href = `?submit_review=1&item=${item_name}&rating=${star_value}&review=${review}`;
    var rating = document.getElementById('star_rating'+item_name);
    var sub = document.getElementById('submit_rating'+item_name);
    rating.innerHTML = "";
    sub.innerHTML = `Already Rated<button class="btn" onclick="return get_reviews('${item_name}','${reviews_present}',${true})">Reviews</button>`;
}

function submit_restaurant_rating(given){
    var holder = document.getElementById('website_rating');
    if(given){
        holder.innerHTML = "";
    }
    else{
        holder.innerHTML= `
        <form action="display_menu.php" method="post" class="form-group">
        <div class="star-icon">
            <input type="radio" name="res_rating" id="res_rating1" value="1">
            <label for="res_rating1" >★</label>
            <input type="radio" name="res_rating" id="res_rating2" value="2">
            <label for="res_rating2" >★</label>
            <input type="radio" name="res_rating" id="res_rating3" value="3">
            <label for="res_rating3" >★</label>
            <input type="radio" name="res_rating" id="res_rating4" value="4">
            <label for="res_rating4" >★</label>
            <input type="radio" name="res_rating" id="res_rating5" value="5" checked>
            <label for="res_rating5" >★</label>
            <br>
        </div>
        
        <textarea class="review_to_give" name="res_review" id="res_review" cols="30" rows="10" placeholder="Your Review about the restaurant. Feel free to mention anything." value=''></textarea>
        <br><br><button class="btn" type='submit' name='submit'>submit</button>
        </form>
        `;
    }
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