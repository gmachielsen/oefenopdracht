<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsArticles = [
            [
                'title' => 'Nieuwe functionaliteiten aangekondigd voor 2025',
                'description' => 'Ontdek de spannende nieuwe features die dit jaar worden uitgerold, waaronder verbeterde gebruikersinterface en geavanceerde rapportages.',
                'content' => 'We zijn verheugd om aan te kondigen dat er dit jaar verschillende nieuwe functionaliteiten worden toegevoegd aan ons platform. Deze updates zijn gebaseerd op feedback van onze gebruikers en zullen de algehele ervaring aanzienlijk verbeteren.

Onder de nieuwe features vinden we:
- Een volledig vernieuwde dashboard interface
- Geavanceerde filtering en zoekopties
- Realtime notificaties en updates
- Verbeterde mobile responsiveness
- Nieuwe rapportage tools met exportfunctionaliteit

Deze updates worden gefaseerd uitgerold over de komende maanden. We zullen onze gebruikers tijdig informeren over elke nieuwe release.',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Beveiligingsupdate: Belangrijke verbeteringen geïmplementeerd',
                'description' => 'Een uitgebreide beveiligingsupdate is uitgerold om de veiligheid van gebruikersgegevens verder te versterken.',
                'content' => 'De veiligheid van onze gebruikers staat altijd voorop. Daarom hebben we recentelijk een uitgebreide beveiligingsupdate geïmplementeerd die verschillende aspecten van onze platform beveiligt.

Belangrijkste verbeteringen:
- Versterkte encryptie voor alle datatransmissies
- Implementatie van multi-factor authenticatie
- Verbeterde session management
- Automatische detectie van verdachte activiteiten
- Regular security audits en penetration testing

We adviseren alle gebruikers om hun wachtwoorden te updaten en waar mogelijk gebruik te maken van de nieuwe beveiligingsfeatures. Voor vragen over beveiliging kunt u contact opnemen met ons support team.',
                'image_url' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Succesvolle lancering van mobiele applicatie',
                'description' => 'Onze nieuwe mobiele app is nu beschikbaar in de App Store en Google Play Store met alle kernfunctionaliteiten.',
                'content' => 'Na maanden van ontwikkeling en testing zijn we trots om de lancering van onze mobiele applicatie aan te kondigen. De app is nu beschikbaar voor zowel iOS als Android gebruikers.

Kernfunctionaliteiten van de app:
- Volledige synchronisatie met de web applicatie
- Offline functionaliteit voor essentiële features
- Push notificaties voor belangrijke updates
- Intuïtieve touch interface geoptimaliseerd voor mobiel gebruik
- Biometrische authenticatie ondersteuning

De app heeft een moderne, gebruiksvriendelijke interface die is ontworpen met de mobiele gebruiker in gedachten. Download nu gratis via de App Store of Google Play Store en ervaar de vrijheid van mobiele toegang tot al onze services.',
                'image_url' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subWeek(),
            ],
            [
                'title' => 'Klanttevredenheidsonderzoek: Uitstekende resultaten',
                'description' => 'Ons jaarlijkse klanttevredenheidsonderzoek toont een score van 4.8/5.0, een nieuwe record voor ons bedrijf.',
                'content' => 'We zijn enorm trots om de resultaten van ons jaarlijkse klanttevredenheidsonderzoek te delen. Met een gemiddelde score van 4.8 uit 5.0 hebben we een nieuwe mijlpaal bereikt.

Hoogtepunten uit het onderzoek:
- 94% van de klanten beveelt ons aan bij collega\'s
- Gebruiksgemak scoort gemiddeld 4.9/5.0
- Klantenservice ontvangt een 4.7/5.0
- 89% van de gebruikers is "zeer tevreden" met onze dienstverlening
- Response tijd op support tickets verbeterd met 40%

Deze geweldige resultaten motiveren ons om door te gaan met innoveren en de beste service te blijven leveren. We danken al onze klanten voor hun vertrouwen en waardevolle feedback.',
                'image_url' => 'https://images.unsplash.com/photo-1553484771-371a605b060b?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Nieuwe integraties beschikbaar: Verbind met populaire tools',
                'description' => 'Uitbreiding van ons integratieplatform met ondersteuning voor Slack, Microsoft Teams, en andere populaire business tools.',
                'content' => 'We breiden ons integratieplatform uit met ondersteuning voor enkele van de meest populaire business tools van vandaag de dag. Deze nieuwe integraties maken het nog eenvoudiger om ons platform te integreren in uw bestaande workflow.

Nieuwe integraties:
- Slack: Ontvang notificaties en updates direct in uw Slack kanalen
- Microsoft Teams: Naadloze integratie met Teams voor verbeterde samenwerking
- Google Workspace: Synchronisatie met Gmail, Calendar en Drive
- Salesforce: Automatische data synchronisatie met uw CRM
- Zapier: Verbind met 1000+ apps via Zapier integraties

Het instellen van deze integraties is eenvoudig via onze nieuwe integratie wizard in de instellingen. Stap-voor-stap instructies zijn beschikbaar in onze kennisbank.',
                'image_url' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(14),
            ],
            [
                'title' => 'Webinar: Best Practices voor Productiviteit',
                'description' => 'Sluit je aan bij ons gratis webinar volgende week over het maximaliseren van productiviteit met onze tools.',
                'content' => 'We organiseren een gratis webinar voor al onze gebruikers over het maximaliseren van productiviteit met onze platform tools. Dit is een geweldige kans om meer te leren over geavanceerde features en tips van onze experts.

Webinar details:
- Datum: Donderdag 20 augustus 2025
- Tijd: 14:00 - 15:30 CET
- Spreker: Sarah van der Berg, Product Specialist
- Locatie: Online via Zoom
- Kosten: Gratis voor alle gebruikers

Onderwerpen die worden behandeld:
- Geavanceerde zoek- en filterfuncties
- Automatisering van routinetaken
- Efficiënt gebruik van rapportage tools
- Integratiestrategieën voor teams
- Q&A sessie met live vragen

Registratie is verplicht vanwege beperkte capaciteit. Alle deelnemers ontvangen na afloop een opname van de sessie.',
                'image_url' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Onderhoudswerkzaamheden aangekondigd voor komend weekend',
                'description' => 'Geplande onderhoudswerkzaamheden zaterdag 17 augustus van 02:00 tot 06:00 CET voor systeem optimalisaties.',
                'content' => 'We willen u informeren over geplande onderhoudswerkzaamheden komend weekend. Deze werkzaamheden zijn noodzakelijk om de prestaties en stabiliteit van ons platform verder te verbeteren.

Onderhoudsdetails:
- Datum: Zaterdag 17 augustus 2025
- Tijd: 02:00 - 06:00 CET (Nederlandse tijd)
- Verwachte duur: Maximaal 4 uur
- Impact: Platform tijdelijk niet beschikbaar

Werkzaamheden omvatten:
- Database optimalisatie en indexering
- Server hardware upgrades
- Netwerk infrastructuur verbeteringen
- Backup systeem tests
- Security patches installatie

We hebben dit tijdstip gekozen om de impact op onze gebruikers te minimaliseren. Alle data blijft veilig bewaard en er gaat geen informatie verloren. We verwachten dat het platform na de werkzaamheden sneller en stabieler zal functioneren.',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subHours(6),
            ],
            [
                'title' => 'Nieuwe teamleden verwelkomen: Uitbreiding van support team',
                'description' => 'We verwelkomen drie nieuwe teamleden in ons customer support team om nog betere service te kunnen leveren.',
                'content' => 'Ons team groeit! We zijn verheugd om drie nieuwe collega\'s te verwelkomen die ons customer support team komen versterken. Deze uitbreiding stelt ons in staat om nog betere en snellere service te leveren aan al onze klanten.

Nieuwe teamleden:
- Lisa Janssen: Customer Success Specialist met 5 jaar ervaring in SaaS
- Mark de Vries: Technical Support Engineer gespecialiseerd in API integraties
- Emma Bakker: Support Coordinator met expertise in procesoptimalisatie

Met deze aanvullingen kunnen we:
- Snellere response tijden garanderen
- Uitgebreidere technische ondersteuning bieden
- Meer proactieve customer success initiatieven opstarten
- Betere 24/7 support coverage realiseren

Al onze nieuwe collega\'s brengen waardevolle ervaring mee en zijn enthousiast om onze klanten te helpen succesvol te zijn met ons platform.',
                'image_url' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(8),
            ],
        ];

        foreach ($newsArticles as $article) {
            News::create($article);
        }
    }
}
