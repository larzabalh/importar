function RandomPassword(Length, Upper, Numbers, Lower)
{
    Upper = typeof(Upper) != 'undefined' ? Upper : true;
    Numbers = typeof(Numbers) != 'undefined' ? Numbers : true;
    Lower = typeof(Lower) != 'undefined' ? Lower : true;

    if (!Upper && !Lower && !Numbers)
        return "";

    var Ret = "";
    var Num;
    var Repeat;

    Chars = 26 * 2 + 10;    //26 (a-z) + 26 (A-Z) + 10 (0-9)
    //a-z = 97-122
    //A-Z = 65-90
    //0-9 = 48-57

    for (i = 1; i <= Length; i++)
    {
        Repeat = false;

        Num = Math.floor(Math.random()*Chars);

        if (Num < 26)
            if (Lower)
                Ret = Ret + String.fromCharCode(Num + 97);
            else
                Repeat = true;
        else if (Num < 52)
            if (Upper)
                Ret = Ret + String.fromCharCode(Num - 26 + 65);
            else
                Repeat = true;
        else if (Num < 62)
            if (Numbers)
                Ret = Ret + String.fromCharCode(Num - 52 + 48);
            else
                Repeat = true;

        if (Repeat)
            i--;
    }

    return Ret;
}
