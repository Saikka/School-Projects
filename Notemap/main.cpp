#include <QGuiApplication>
#include <QQmlApplicationEngine>
#include <QQmlContext>

#include "database.h"
#include "listmodel.h"
#include "dateclass.h"
#include "notificationclient.h"

int main(int argc, char *argv[])
{
    QCoreApplication::setAttribute(Qt::AA_EnableHighDpiScaling);
    QGuiApplication app(argc, argv);
    QQmlApplicationEngine engine;

    DataBase database;
    database.connectToDataBase();

    ListModel *model = new ListModel();  
    DateClass* dateClass = new DateClass();
    NotificationClient* notificationClient = new NotificationClient();

    engine.rootContext()->setContextProperty("notificationClient", notificationClient);
    engine.rootContext()->setContextProperty("dateClass", dateClass);
    engine.rootContext()->setContextProperty("myModel", model);
    engine.rootContext()->setContextProperty("database", &database);

    engine.load(QUrl(QStringLiteral("qrc:/main.qml")));

    return app.exec();
}
