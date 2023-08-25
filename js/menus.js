var serial = 0;
function add10(){
    var table = document.getElementById('item_list');
    for(var i=0;i<10;i++){
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        cell1.innerHTML = ++serial;
        cell2.innerHTML = `<input type='text' name='Item${serial}' 
        id='item${serial}' value='' placeholder='Item ${serial}'>`;
        cell3.innerHTML = `<input type='number' name='Price${serial}' 
        id='price${serial}' value='' placeholder='Price ${serial}'>
        <span id='price_miss_${serial}' class='err_msg'></span>`;
        cell4.innerHTML = `<input type="file" name="image${serial}" id="image${serial}" accept="image/*" value=''>
                            <span id='img_miss_${serial}' class='err_msg'></span>`;
        cell5.innerHTML = `<textarea name='desc${serial}' id='desc${serial}' placeholder='Describe your dish' rows='3' cols='30'></textarea>`;
    }
}


function verify(){
    var flag = true;
    var empty = true;
    for(let i=serial;i>0;i--){
        var dish = document.getElementById(`item${i}`).value;
        var cost = document.getElementById(`price${i}`).value;
        var img = document.getElementById(`image${i}`).value;
        if(dish!=''){
            empty = false;
            if(cost==''){
                document.getElementById(`price_miss_${i}`).innerHTML="<br>**required**";
                flag = false;
            }
            else{
                document.getElementById(`price_miss_${i}`).innerHTML="";
            }
            if(img==''){
                document.getElementById(`img_miss_${i}`).innerHTML="<br>**required**";
                flag = false;
            }
            else{
                document.getElementById(`img_miss_${i}`).innerHTML="";
            }
        }
    }
    if(empty){
        alert("No items inserted");
        return(false);
    }
    document.getElementById('count').value = serial;
    return(flag);
}



