#UC1 Autentisera användare

##Huvudscenario

1. Startar när en användare vill autentisera sig.
2. Systemet ber om användarnamn och lösenord och valet att spara uppgifter
3. Användaren anger användarnamn och lösenord
4. Systemet autentierar användaren och presenterar att autentiseringen lyckades

##Alternativa scenarion

3a. Användaren anger att spara uppgifter
1. Systemet autentisierar användaren och presenterar att autentiseringen lyckades och att uppgifterna har sparats.

4a. Användaren kunde inte autentisieras
1. Systemet presenterar felmeddelande
2. Gå till steg 2 i huvudscenariot.

#UC2 Utloggning av autentiserad användare

##Förkrav

1. Användaren är autentiserad. Ex UC1, UC3

##Huvudscenario

1. Startar när en användare inte längre vill vara inloggad
2. Systemet presenterar val för utloggning
3. Användaren anger att den vill logga ut.
4. Systemet loggar ut användaren
