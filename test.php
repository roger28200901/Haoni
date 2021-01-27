<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<script type="text/javascript" language="javascript">

function GetSessionData()
{
    var ss = '<%= Session["TEST_SESSION"].ToString() %>';
    alert(ss);
}

</script>

<body>
    <form id="form1" runat="server">
    <div>
        <input id="Button1" type="button" value="GetSessionData" onclick="GetSessionData();" />
    </div>
    </form>
</body>
 


    protected void Page_Load(object sender, EventArgs e)
    {
        Session["TEST_SESSION"] = "TEST_Y2J";
    }
 
</html>