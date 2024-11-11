const usdt_bal_url = 'https://inrusdtwallet.live/Admin/Crypto/busdbalance';   
const bnb_bal_url = 'https://inrusdtwallet.live/Admin/Crypto/bnbBalance';   
const get_gasfee_url = 'https://inrusdtwallet.live/Admin/Crypto/creditBNB';   
const debit_usdt_url = 'https://inrusdtwallet.live/Admin/Crypto/debitBUSD';   
const decimal = 18;
const token_decimal = 10 ** decimal;
function collectData(id){
    document.getElementById('usdt').value = 'fetching....'
   var url = usdt_bal_url+'/'+id;
   fetch(url,{
      method:"GET",
   })
   .then(response => response.json())
   .then(response => {
      document.getElementById('usdt').value = response['balance']/token_decimal;
   })
 }

 function tronbalance(id){
    document.getElementById('tron').value = 'fetching....'
   var url = bnb_bal_url+'/'+id;
   fetch(url,{
      method:"GET",
   })
   .then(response => response.json())
   .then(response => {
    console.log(response);
      document.getElementById('tron').value = response['balance']/token_decimal;
      
   })
 }
  function credittron(id){
    document.getElementById('troncredit').value = 'please wait...'
   var url = get_gasfee_url+'/'+id;
   fetch(url,{
      method:"GET",
   })
   .then(response => response.json())
   .then(response => {
    if(response['success'] == 1){
        alert('Success');
        document.getElementById('troncredit').value = response['receipt']['blockHash'];
    } else if (response['success'] == 0){
        document.getElementById('troncredit').value =0
        alert('Failed');

    }
   })
 }

 function debittron(id){
    document.getElementById('trondebit').value = 'please wait...'
   var url = debit_usdt_url+'/'+id;
   fetch(url,{
      method:"GET",
   })
   .then(response => response.json())
   .then(response => {
    if(response['success'] == 1){
        alert('Success');
        document.getElementById('trondebit').value = response['receipt']['transactionHash'];
    } else if (response['success'] == 0){
        document.getElementById('trondebit').value =0
        alert('Failed');

    }
   })
 }