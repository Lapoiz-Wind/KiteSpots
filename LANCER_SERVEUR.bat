@echo off
REM Script de lancement du serveur Symfony - KiteSpots
REM Aucun droit admin requis

echo.
echo ============================================
echo  KiteSpots - Lancement du serveur
echo ============================================
echo.

REM Définir les chemins
set PHP_PATH=C:\php\php.exe
set KITESPOTS_PATH=C:\Users\dpoizat\OneDrive - Sopra Steria\Documents\LapoizWind-2026\kitespots

REM Vérifier que PHP existe
if not exist "%PHP_PATH%" (
    echo [ERREUR] PHP non trouvé à : %PHP_PATH%
    pause
    exit /b 1
)

echo [OK] PHP trouvé
echo.

REM Aller au répertoire public
cd /d "%KITESPOTS_PATH%\public"

if errorlevel 1 (
    echo [ERREUR] Impossible d'accéder à : %KITESPOTS_PATH%\public
    pause
    exit /b 1
)

echo [OK] Répertoire public : %cd%
echo.

REM Lancer le serveur
echo Lancement du serveur à http://127.0.0.1:8000
echo.
echo Appuyez sur Ctrl+C pour arrêter le serveur
echo.

"%PHP_PATH%" -S 127.0.0.1:8000

pause
