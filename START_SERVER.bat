@echo off
REM Script de démarrage du serveur Symfony Kitespots
REM Date: 2026-08-02

echo.
echo ========================================
echo   🎯 SERVEUR KITESPOTS
echo ========================================
echo.

REM Changement vers le répertoire du projet
cd /d "C:\Users\dpoizat\OneDrive - Sopra Steria\Documents\LapoizWind-2026\kitespots"

echo 📁 Répertoire: %cd%
echo.

REM Vérification de PHP
echo ✓ Démarrage du serveur PHP...
echo   Adresse: http://127.0.0.1:8000
echo   Port: 8000
echo.
echo 🌐 Accès au site: http://localhost:8000
echo.
echo ⏹️  Appuyez sur Ctrl+C pour arrêter le serveur
echo.
echo ========================================
echo.

REM Lancer le serveur
"C:\php\php.exe" -S 127.0.0.1:8000 -t public

pause
