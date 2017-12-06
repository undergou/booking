<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>London site</title>
    <link rel="stylesheet" href="/project3-1/booking/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/project3-1/booking/admin/css/css-admin.css">
</head>

<style>
.main{
    width:600px;
    margin: 0 auto;
    border: 1px solid black;
}
.header{
    height: 200px;
    border-bottom: 1px solid black;
    position: relative;
}
.content{
    border-bottom: 1px solid black;
    padding: 0 20px;
}
.footer{
    padding-top: 10px;
    font-weight: bold;
    text-align: center;
    height: 30px;
}
    .booking{
        border: 1px solid red;
        padding: 20px;
    }
.alert-success{
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.alert-danger{
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
.alert{
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
    #result{
        margin-top: 20px;
    }

</style>

<body>

<div class="main">
    <div class="header"><img src="images/england.jpg" alt=""></div>
    <div class="content">
        <h1>London</h1>

        <?php require_once __DIR__ .'/booking/helper.php';
            $h = new BookingHelper();
            echo $h->getBookingHelper();
        ?>
      <p>London is the capital and most populous city of England and the United Kingdom.</p>

        <p> Standing on the River Thames in the south east of the island of Great Britain, London has been a major settlement for two millennia. It was founded by the Romans, who named it Londinium.[10] London's ancient core, the City of London, largely retains its 1.12-square-mile (2.9 km2) medieval boundaries. Since at least the 19th century, "London" has also referred to the metropolis around this core, historically split between Middlesex, Essex, Surrey, Kent and Hertfordshire,[11][12][13] which today largely makes up Greater London,[14][15][note 1] a region governed by the Mayor of London and the London Assembly.</p>

        <p> London is a leading global city[18][19] in the arts, commerce, education, entertainment, fashion, finance, healthcare, media, professional services, research and development, tourism and transportation.[20][21][22] It is the world's largest financial centre[23][24][25][26] and has the fifth- or sixth-largest metropolitan area GDP in the world.[note 3][27][28] London is a world cultural capital.[29][30][31] It is the world's most-visited city as measured by international arrivals[32] and has the world's largest city airport system measured by passenger traffic.[33] London is the world's leading investment destination,[34][35][36][37] hosting more international retailers[38][39] and ultra high-net-worth individuals[40][41] than any other city. London's universities form the largest concentration of higher education institutes in Europe.[42] In 2012, London became the first city to have hosted the modern Summer Olympic Games three times.</p>

        <p> London has a diverse range of people and cultures, and more than 300 languages are spoken in the region.[44] Its estimated mid-2016 municipal population (corresponding to Greater London) was 8,787,892,[3] the largest of any city in the European Union[45] and accounting for 13.4% of the UK population.[46] London's urban area is the second most populous in the EU, after Paris, with 9,787,426 inhabitants at the 2011 census.[47] The city's metropolitan area is the most populous in the EU with 13,879,757 inhabitants,[note 4][2] while the Greater London Authority states the population of the city-region (covering a large part of the south east) as 22.7 million.[48][49] London was the world's most populous city from around 1831 to 1925.</p>

        <p> London contains four World Heritage Sites: the Tower of London; Kew Gardens; the site comprising the Palace of Westminster, Westminster Abbey, and St Margaret's Church; and the historic settlement of Greenwich (in which the Royal Observatory, Greenwich defines the Prime Meridian, 0° longitude, and GMT).[51] Other famous landmarks include Buckingham Palace, the London Eye, Piccadilly Circus, St Paul's Cathedral, Tower Bridge, Trafalgar Square and The Shard. London is home to numerous museums, galleries, libraries, sporting events and other cultural institutions, including the British Museum, National Gallery, Natural History Museum, Tate Modern, British Library and West End theatres.</p>

        <p> The London Underground is the oldest underground railway network in the world.</p>
    </div>
    <div class="footer">Site about London 2017</div>
</div>



<script type="text/javascript" src="booking/js/jquery.js"></script>
<script type="text/javascript" src="booking/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="booking/js/scripts-validate.js"></script>
<script type="text/javascript" src="booking/js/request.js"></script>
<script type="text/javascript" src="booking/js/scripts-ui.js"></script>


</body>
</html>
