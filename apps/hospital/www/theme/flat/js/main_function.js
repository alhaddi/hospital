/* 
	** Developed by Amir Mufid **
*/
function addZero(i) {
	if (i < 10) 
	{
		i = "0" + i;
	}
	return i;
}

function array_compare(a1, a2) {
    if (a1.length != a2.length) return false;
    var length = a2.length;
    for (var i = 0; i < length; i++) 
	{
        if (a1[i] !== a2[i]) return false;
	}
    return true;
}

function in_array(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) 
	{
        if(typeof haystack[i] == 'object') 
		{
            if(array_compare(haystack[i], needle)) return true;
		} 
		else 
		{
            if(haystack[i] == needle) return true;
		}
	}
    return false;
}

function rupiah(hasil)
{
	//format rp;
	num = hasil;
	
	num = num.toString().replace(/\Rp|/g,'');
	if(isNaN(num))
	num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10)
	cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
	num = num.substring(0,num.length-(4*i+3))+'.'+
	num.substring(num.length-(4*i+3));
	return ((sign)?'':'-') + 'Rp ' + num ;
}

function hitungUsia(birthday) { // birthday is a date
	birthday = birthday.split('/');
	birthday = birthday[2]+'-'+birthday[1]+'-'+birthday[0];
	birthday = new Date(birthday);
    console.log(birthday);
	var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
	var hasil  = Math.abs(ageDate.getUTCFullYear() - 1970);
	if(hasil > 0)
	{
		return hasil;
	}
	else
	{
		return 0;
	}
}