function getData(){
    fetch("getToken.php?token="+localStorage.getItem("token")).then((res) => {
        return res.json();
    }).then((data) =>{
        console.log(data);
    });
}

document.getElementById('getData_id').addEventListener("click", ()=>{
    getData();
});
 document.getElementById("submit").addEventListener("click", ()=>{
    let username = document.getElementById("username").value
    let password = document.getElementById("password").value
    console.log(username)
    fetch(`login.php?username=${username}&password=${password}`).then((res) => {
        return res.json();
    }).then((data) => {
        console.log(data);
        localStorage.setItem("token", data.token);
    }).catch((err) => console.log(err))

})

