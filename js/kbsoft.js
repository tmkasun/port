

$('#result_table tr').mouseover(function(){
    $(this).addClass('highlight');
}).mouseout(function(){
    $(this).removeClass('highlight');
});


/* feedback click function */
var feedbk_clk = false;
function feedback_div_close_function(me){
    $("#feedback_tx").slideToggle("slow");
    $("#feedback_rs").toggle("slow","swing");
    $("#feedbacks_dv_close_img").fadeOut("slow");
    document.getElementById("feedbacks_dv").style.boxShadow = "";
    document.getElementById("feedback_bt").innerHTML = "Send Feedback";
    feedbk_clk = false;
}
/* feedback click function --end*/

//profile pic changer using ajax

//profile pic changer using ajax --end

//on mouse over profile pic changer upload a new profile pic message 
function hover_profilepic_message(){
    //alert("ok");
    $("#profile_pic_upload_div").fadeIn("slow");
   
}


//on mouse over profile pic changer upload a new profile pic message  --end

/* feedback click function */

function feedbk(){
    //alert("enter to feedback function");
    $("#feedback_tx").slideToggle("slow");
    $("#feedback_rs").toggle("slow","swing");
    $("#feedbacks_dv_close_img").fadeIn("slow");
    document.getElementById("feedbacks_dv").style.boxShadow = "0px 0px 20px 1px #08296B";
    document.getElementById("feedback_bt").innerHTML = "Submit Feedback";
    if(!feedbk_clk){
        feedbk_clk = true;
        return 0;
    }
    var feedback = document.getElementById("feedback_tx").value;
    if(!feedback){
        $( "#feedback_tx" ).effect( "shake", 500);
        alert("Please enter some text");
        return 0;
    }
    //alert(feedback);
    var ajax_feedback = new XMLHttpRequest();
    ajax_feedback.onreadystatechange = function(){
        if(ajax_feedback.readyState == 4 & ajax_feedback.status == 200){
            document.getElementById("feedbacks_dv").innerHTML = ajax_feedback.responseText;
            setTimeout(function(){$("#feedbacks_dv").fadeOut("slow");},3000);
        }
    }

    ajax_feedback.open("get","./feedbacks.php/?feedback_tx="+feedback,true);
    ajax_feedback.send();
}

/* feedback click function --end */


//jquery for select phone_numbers rows
function form_vertify(){
    
    var pno1 = document.forms["profile_form"]["pno1"].value;
    var pno2 = document.forms["profile_form"]["pno2"].value;
    //var home = document.forms["profile_form"]["home"].value;
    //var school = document.forms["profile_form"]["school"].value;
    //var sex =  document.forms["profile_form"]["sex"];
    //alert(sex);
    //if(!pno1 && !school && !home && !pno2 && !sex){
    //    alert("Empty changes");
    //    return false;
    //}
    
    if((pno2.length < 10 && pno2.length >1) || (pno1.length < 10 && pno1.length >1)){
        alert("Invalid Phone Number");
        return false;
    }
    
     for(values in pno1){
        if(isNaN(pno1[values])){
            alert("Invalid Phone Number");
            return false;
     }
    }
    
    
    for(values in pno2){
        if(isNaN(pno2[values])){
            alert("Invalid Phone Number");
            return false;
        }
    }
    //alert("false");
    return true;  
  
}
//phone number vertification

function pno_ver(phone_number){
    
    if(phone_number.value.length != 10){
        document.getElementById("pno_stat").setAttribute("src","./mm/no.ico");    
        return false;
    
    }
    else {
        document.getElementById("pno_stat").setAttribute("src","./mm/ok.ico");     
        return true;
    }
}


//add aditional phone number to field
//aditional phone numbers count
function add_pno(){
        
    //var new_pno = document.createElement("input");
    //new_pno.setAttribute("placeholder",'Add atnother phone number');    
    //new_pno.setAttribute("onfocus","add_pno()"); //add multiple new phone numbers
    //var paren = document.getElementById("pno_td");
    //document.getElementById("pno2").style.display = "none";
    //new_pno.setAttribute("name","pno_2");
    
    //paren.appendChild(new_pno);
    $("#pno2").fadeIn("slow");
     //alert("ok");
        
}

//add aditional phone number to field --end

//ajax selector for onclick details display
var ajax_object = new XMLHttpRequest();//move XMLHttpRequest to globle scope
var current_innerHTML = "";
function clk(passed_reg_number){//pass registration number of the student via php  on ajax.php echo
    $("#result_box").slideUp("slow");
    $("#ajax_loading_div").fadeIn("fast");
    var reg_number = passed_reg_number;
    current_innerHTML = document.getElementById("result_box").innerHTML;
    //move XMLHttpRequest to globle scope
    ajax_object.onreadystatechange = ajax_result_view_function;
    ajax_object.open("get","./view.php?reg_number="+reg_number,true);
    ajax_object.send();
    
    
}
//row select for admin users
function clk_admin(rows){
    $("#result_box").slideUp("slow");
    $("#ajax_loading_div").fadeIn("fast");
    var reg_number = rows.id;
    //alert(reg_number);
    current_innerHTML = document.getElementById("result_box").innerHTML;
    //move XMLHttpRequest to globle scope
    ajax_object.onreadystatechange = ajax_result_view_function;
    ajax_object.open("get","./profile.php?reg_number="+reg_number,true);
    ajax_object.send();
    
}
function ajax_result_view_function(){
    //alert(ajax_object.readyState+"and>>>"+ ajax_object.status );
    if(ajax_object.readyState == 4 && ajax_object.status == 200){
        $("#ajax_loading_div").fadeOut("fast");
        document.getElementById("result_box").style.display = "none";
        document.getElementById("result_box").innerHTML = ajax_object.responseText;
        $("#result_box").fadeIn("fast");
    }
    
}

function load_pre_innerHTML(){
    document.getElementById("result_box").style.display = "none";
    document.getElementById("result_box").innerHTML = current_innerHTML ;
    $("#result_box").slideDown("slow");
}



function change_pro_pic(sex){
    
    if(sex == "male"){
            
            document.getElementById("profile_pic").style.display = "none";
            document.getElementById("profile_pic").src = "./mm/derp.png";
            $("#profile_pic").fadeIn("slow");
    }
    else if(sex == 'female'){
            document.getElementById("profile_pic").style.display = "none";
            document.getElementById("profile_pic").src = "./mm/derpina.png";
            
            $("#profile_pic").fadeIn("slow");
    }


}
function slideup(){
    $("#td").slideToggle("slow",load_pre_innerHTML);
    $("button.clear_bt").fadeOut("slow");
}

function ajax_admin(){
    $("#ajax_loading_div").fadeIn("fast");
    var ajx = new XMLHttpRequest();
    ajx.open("get","./admin.php",true);
    ajx.send();
    ajx.onreadystatechange = function(){
            
            if(ajx.readyState == 4 && ajx.status == 200){
                $("#ajax_loading_div").fadeOut("fast");
                    document.getElementById("result_box").style.display = "none";
                    
                    document.getElementById("result_box").innerHTML = ajx.responseText;
                    $("#result_box").slideDown("slow");
            }
    }
    
}

function ajax_profile(){
    document.getElementById("ajax_loading_div").style.display = "";
    var ajx = new XMLHttpRequest();
    ajx.open("get","./profile.php",true);
    ajx.send();
    ajx.onreadystatechange = function(){
            
            if(ajx.readyState == 4 && ajx.status == 200){
                    document.getElementById("ajax_loading_div").style.display = "none";
                    document.getElementById("result_box").style.display = "none";
                    document.getElementById("result_box").innerHTML = ajx.responseText;
                    $("#result_box").slideDown("slow");
            }
    }
    
}
function ajax_search(){
    $("#ajax_loading_div").fadeIn("fast");
    var xmlhttp = new XMLHttpRequest();
    var query =new String(document.getElementById("search").value);
    if(query.length==0){
            return false;
    }
    xmlhttp.open("post","ajax.php?query="+query,true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    document.getElementById("ajax_loading_div").style.display = "none";
                    document.getElementById("result_box").innerHTML = xmlhttp.responseText;
            }
    }
    return false;
    
}

function madu_scrpt(){
    
}

function mo(rows){//mouse over script for red color font
    //alert(pno2);
    rows.style.fontSize = "20";
    rows.style.color = "red";
    return 0;
}

/* set opacity animation on under construction banner*/
var opa_v = 0.8; //opacity of uder construction banner
var count = 3;
function ani(){
    
    var elm = document.getElementById("under_c");
    elm.style.opacity = String(opa_v);
    if(opa_v >= 0.6 && count > 0){
            opa_v -= 0.1;
            count -= 1;
    }
    if(count <= 0 ){
            opa_v += 0.1;
            count -= 1;
            if(count == -3){
                    count = 3;
            }
    }
    setTimeout(ani,250);
/* set opacity animation on under construction banner*/	
}
function moo(rows){
    rows.style.fontSize = "inherit";
    rows.style.color = "black";
    return 0;
}
function name_dis(cname,flag){//upper banner change name to cname effect
    if(flag == 1)
            document.getElementById("name_dis").innerHTML = cname+"&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;&ndash;";
    else if(flag == 2){
            document.getElementById("name_dis").innerHTML = cname;
    }
    
}	
function scrch(){
    document.getElementById("sch").style.backgroundColor = "#EBF5FF" ;
}
function search_f(){//while searching animation
    loading = document.getElementById("search_image");
    
    //loading.src = "./mm/loading.gif";	
    }	