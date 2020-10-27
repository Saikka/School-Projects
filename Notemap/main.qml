import QtQuick.Controls 2.4
import QtQuick.Layouts 1.1
import QtQuick.Dialogs 1.2
import QtQuick.Controls.Styles 1.2
import QtQuick 2.9
import QtQuick.Window 2.2
import QtQuick.Controls 1.4
import QtQuick.Layouts 1.3


import QtLocation 5.9
import QtPositioning 5.11


ApplicationWindow {
    id: window
    visible: true
    width: 440
    height: 1080
    title: qsTr("Note Map")

    Page {
        id: main_page
        visible: true
        anchors.fill: parent

        Rectangle {
            id: rectangle
            color: "#2e2d2d"
            anchors.fill: parent

            Rectangle {
                id: rectangle2
                width: parent.width
                height: 40
                color: "#636161"

                Text {
                    id: text1
                    color: "white"
                    text: qsTr("TO DO LIST")
                    anchors.top: parent.top
                    anchors.topMargin: 0
                    anchors.left: parent.left
                    anchors.leftMargin: 10
                    font.bold: true
                    font.pixelSize: 30
                }
            }

            Button {
                id: button_back
                text: qsTr("<<")
                anchors.right: button_date.left
                anchors.rightMargin: 0
                anchors.top: rectangle2.bottom
                anchors.topMargin: 0
                width: 100
                height: 40
                onClicked: {
                    button_date.text = dateClass.prev_day(button_date.text)
                    myModel.updateModel(button_date.text)
                }
                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 24
                        font.bold: true
                        color: "white"
                        text: control.text
                    }
                    background: Rectangle {
                        color: "#2e2d2d"
                    }
                }
            }

            Button {
                id: button_date
                y: 40
                text:  dateClass.getDate()
                anchors.horizontalCenterOffset: 0
                anchors.horizontalCenter: parent.horizontalCenter
                anchors.top: rectangle2.bottom
                anchors.topMargin: 0
                width: 125
                height: 40
                onClicked: {
                    calendar.visible = true
                }
                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 24
                        font.bold: true
                        color: "white"
                        text: control.text
                    }
                    background: Rectangle {
                        color: "#2e2d2d"
                    }
                }
            }

            Button {
                id: button_forward
                width: 100
                height: 40
                text: qsTr(">>")
                anchors.left: button_date.right
                anchors.leftMargin: 0
                anchors.top: rectangle2.bottom
                anchors.topMargin: 0
                Layout.alignment: Qt.AlignRight | Qt.AlignVCenter
                onClicked: {
                    button_date.text = dateClass.next_day(button_date.text)
                    myModel.updateModel(button_date.text)
                }
                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 24
                        font.bold: true
                        color: "white"
                        text: control.text
                    }
                    background: Rectangle {
                        color: "#2e2d2d"
                    }
                }
            }

        Rectangle {
            width: 300;
            height: 300
            anchors.horizontalCenter: parent.horizontalCenter
            anchors.top: button_date.bottom
            anchors.topMargin: 20
            color: "#2e2d2d"

            ListView {
                id: list_tasks
                model: myModel
                delegate: listdelegate
                anchors.fill: parent
                spacing: 5

            }

            Component {
                id: listdelegate

                Rectangle {
                    width: 300
                    height: col.childrenRect.height
                    color: "#E1E1E1"
                    border.color: "#000000"

                    Column {
                        id: col
                        width: parent.width
                        Rectangle {
                            width: parent.width
                            height: 30
                            color: "#A6A6A6"
                            Text {
                                id: name
                                width: parent.width
                                text: model.name
                                font.pointSize: 20
                                leftPadding: 10
                            }
                            MouseArea {
                                anchors.fill: parent
                                onClicked: {
                                    if(details.height === details.collapseHeightFlag) {
                                        details.height = 0;
                                        details.visible = false;
                                    }
                                    else {
                                        details.height = details.collapseHeightFlag;
                                        details.visible = true;
                                    }
                                }
                            }
                        }

                        Column {
                            id: details
                            height: 0
                            visible: false
                            padding: 5
                            property int collapseHeightFlag: childrenRect.height
                            Text {
                                id: address
                                text: "Address: " + model.city + ", " + model.address
                            }
                            Text {
                                id: time
                                text: "Time: " + model.time
                            }
                            Text {
                                id: notes
                                text: "Notes: " + model.notes
                            }

                            Row {
                                padding: 10
                                spacing: 10
                                Button {
                                    text: qsTr("EDIT")
                                    width: 100
                                    height: 30
                                    onClicked: {
                                        myModel.getTask(myModel.getId(index));
                                        name_edit.text = myModel.setName();
                                        city_edit.text = myModel.setCity();
                                        address_edit.text = myModel.setAddress();
                                        time_edit.text = myModel.setTime();
                                        if (myModel.setColor() != col_edit.model.get(0).text) {
                                            var tmp = col_edit.model.get(0).text;
                                            var i = col_edit.find(myModel.setColor());
                                            col_edit.model.get(0).text = myModel.setColor();
                                            col_edit.model.get(i).text = tmp;
                                        }
                                        notes_edit.text = myModel.setNotes();
                                        main_page.visible = false;
                                        edit_page.visible = true;
                                    }
                                    style: ButtonStyle {
                                        label: Text {
                                            renderType: Text.NativeRendering
                                            verticalAlignment: Text.AlignVCenter
                                            horizontalAlignment: Text.AlignHCenter
                                            font.family: "Helvetica"
                                            font.pointSize: 16
                                            font.bold: true
                                            color: "black"
                                            text: control.text
                                        }
                                        background: Rectangle {
                                            color: "#A6A6A6"
                                        }
                                    }
                                }

                                Button {
                                    text: qsTr("DELETE")
                                    width: 100
                                    height: 30
                                    onClicked: {
                                        myModel.ind(index);
                                        dialogDelete.open();
                                    }
                                    style: ButtonStyle {
                                        label: Text {
                                            renderType: Text.NativeRendering
                                            verticalAlignment: Text.AlignVCenter
                                            horizontalAlignment: Text.AlignHCenter
                                            font.family: "Helvetica"
                                            font.pointSize: 16
                                            font.bold: true
                                            color: "black"
                                            text: control.text
                                        }
                                        background: Rectangle {
                                            color: "#A6A6A6"
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } //list rect

        Calendar {
            id: calendar
            visible: false
            anchors.centerIn: parent
            onClicked: {
                calendar.visible = false
                button_date.text = Qt.formatDate(calendar.selectedDate, "dd.MM.yyyy");
                myModel.updateModel(button_date.text)
            }

            style: CalendarStyle {
                dayDelegate: Item {
                    Rectangle {
                        id: rect
                        anchors.fill: parent
                    }

                    Label {
                        id: dayDelegateText
                        text: styleData.date.getDate()
                        anchors.centerIn: parent
                        horizontalAlignment: Text.AlignRight
                        font.pixelSize: Math.min(parent.height/3, parent.width/3)
                        color: styleData.selected ? "red" : "black"
                        font.bold: styleData.selected
                    }

                }
            }

        }

        Button {
            id: show_map
            text: qsTr("Map")
            width: 50
            height: 50
            anchors.bottom: parent.bottom
            anchors.bottomMargin: 10
            anchors.left: parent.left
            anchors.leftMargin: 10

            onClicked: {
                main_page.visible = false;
                map_page.visible = true;

            }

            style: ButtonStyle {
                label: Text {
                    renderType: Text.NativeRendering
                    verticalAlignment: Text.AlignVCenter
                    horizontalAlignment: Text.AlignHCenter
                    font.family: "Helvetica"
                    font.pointSize: 20
                    font.bold: true
                    color: "black"
                    text: control.text

                }
                background: Rectangle {
                    color: "#E1E1E1"
                    border.color: "#E1E1E1"
                    radius: width * 0.5
                }
            }
        }

        Button {
            id: button_add
            text: qsTr("+")
            width: 50
            height: 50
            anchors.bottom: parent.bottom
            anchors.bottomMargin: 10
            anchors.right: parent.right
            anchors.rightMargin: 10

            onClicked: {
                add_page.visible = true;
                main_page.visible = false;
                name.text = "";
                city.text = "";
                address.text = "";
                time.text = "";
                notes.text = "";
                old.currentIndex = 0;
            }

            style: ButtonStyle {
                label: Text {
                    renderType: Text.NativeRendering
                    verticalAlignment: Text.AlignVCenter
                    horizontalAlignment: Text.AlignHCenter
                    font.family: "Helvetica"
                    font.pointSize: 20
                    font.bold: true
                    color: "black"
                    text: control.text

                }
                background: Rectangle {
                    color: "#E1E1E1"
                    border.color: "#E1E1E1"
                    radius: width * 0.5
                }
            }
        }
     } //rect of main page

        MessageDialog {
            id: dialogDelete
            title: qsTr("Deleting element")
            text: qsTr("Are you sure you want to delete?")
            icon: StandardIcon.Warning
            standardButtons: StandardButton.Ok | StandardButton.Cancel

            onAccepted: {
                database.removeRecord(myModel.getId(myModel.setId()));
                myModel.updateModel(button_date.text);
                old.model = myModel.getOldTasks();
                notificationClient.notification = "Task delited at: " + dateClass.current_time()
            }
        }
    }//page main

    Page {
        id: add_page
        visible: false
        anchors.fill: parent

        Rectangle {
            id: rectangle3
            color: "#2e2d2d"
            anchors.fill: parent

            Rectangle {
                id: rectangle4
                width: parent.width
                height: 40
                color: "#636161"

                Text {
                    id: text2
                    color: "white"
                    text: qsTr("ADD TASK")
                    anchors.top: parent.top
                    anchors.topMargin: 0
                    anchors.left: parent.left
                    anchors.leftMargin: 10
                    font.bold: true
                    font.pixelSize: 30
                }

            }

            Rectangle {
                id: rectangle5
                color: "#2e2d2d"
                anchors.bottom: button_commit.top
                anchors.bottomMargin: 0
                anchors.right: parent.right
                anchors.rightMargin: 10
                anchors.left: parent.left
                anchors.leftMargin: 10
                anchors.top: rectangle4.bottom
                anchors.topMargin: 10

                Text {
                    id: text3
                    text: "Date: " + button_date.text
                    font.bold: true
                    font.underline: true
                    fontSizeMode: Text.HorizontalFit
                    font.pixelSize: 20
                    color: "white"
                }

                ComboBox {
                    id: old
                    width: 320
                    height: 30
                    anchors.top: text3.bottom
                    anchors.topMargin: 20
                    model: myModel.getOldTasks()

                    onCurrentIndexChanged: {
                            myModel.getOldTask(old.currentText);
                            name.text = myModel.setName();
                            city.text = myModel.setCity();
                            address.text = myModel.setAddress();
                            time.text = myModel.setTime();
                            notes.text = myModel.setNotes();
                        }

                    style: ComboBoxStyle {
                            id: comboBox
                            background: Rectangle {
                                id: rectCategory
                                radius: 5
                                border.width: 2
                                color: "#fff"
                            }
                            label: Text {
                                verticalAlignment: Text.AlignVCenter
                                font.pointSize: 20
                                color: "black"
                                text: control.currentText
                            }
                        }
                }


                Text {
                    id: text4
                    text: qsTr("Task:")
                    anchors.top: old.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: name
                    width: 200
                    height: 30
                    anchors.top: old.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }


                Text {
                    id: text5
                    text: qsTr("City:")
                    anchors.top: text4.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: city
                    text: ""
                    width: 200
                    height: 30
                    anchors.top: text4.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text6
                    text: qsTr("Address:")
                    anchors.top: text5.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: address
                    text: ""
                    width: 200
                    height: 30
                    anchors.top: text5.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text7
                    text: qsTr("Time:")
                    anchors.top: text6.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: time
                    text: ""
                    width: 200
                    height: 30
                    anchors.top: text6.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text8
                    text: qsTr("Color:")
                    anchors.top: text7.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                ComboBox {
                    id: col
                    width: 200
                    height: 30
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    anchors.top: text7.bottom
                    anchors.topMargin: 20
                    model: ListModel {
                       id: colors
                       ListElement { text: "Blue" }
                       ListElement { text: "Red" }
                       ListElement { text: "Green" }
                       ListElement { text: "Yellow" }
                       ListElement { text: "Black" }
                       ListElement { text: "Pink" }
                       ListElement { text: "Purple" }
                   }
                    style: ComboBoxStyle {
                            background: Rectangle {
                                radius: 5
                                border.width: 2
                                color: "#fff"
                            }
                            label: Text {
                                verticalAlignment: Text.AlignVCenter
                                font.pointSize: 20
                                color: "black"
                                text: control.currentText
                            }
                        }
                }

                Text {
                    id: text9
                    text: qsTr("Notes:")
                    anchors.top: text8.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: notes
                    text: ""
                    width: 200
                    height: 80
                    anchors.top: text8.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: err
                    text: ""
                    color: "#cb3939"
                    font.capitalization: Font.AllUppercase
                    font.italic: true
                    anchors.horizontalCenter: parent.horizontalCenter
                    anchors.top: notes.bottom
                    anchors.topMargin: 10
                    font.pixelSize: 20
                }

            }

            Button {
                id: button_commit
                text: qsTr("Commit")
                anchors.left: parent.left
                anchors.leftMargin: 10
                width: 150
                height: 50
                anchors.bottom: parent.bottom
                anchors.bottomMargin: 10

                onClicked: {
                    if (name.text == "") err.text = "Write task!";
                    else {
                        database.inserIntoTable(button_date.text, name.text, city.text, address.text, time.text, col.currentText, notes.text)
                        myModel.updateModel(button_date.text)
                        main_page.visible = true;
                        add_page.visible =false;
                        old.model = myModel.getOldTasks();
                        messages.displayMessage("Task successfully added!");
                        notificationClient.notification = "Task added at: " + dateClass.current_time()
                    }
                }

                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 20
                        font.bold: true
                        color: "black"
                        text: control.text

                    }
                    background: Rectangle {
                        color: "#E1E1E1"
                        border.color: "#E1E1E1"
                        radius: width * 0.5
                    }
                }
         }

            Button {
                id: button_cancel
                text: qsTr("Cancel")
                anchors.right: parent.right
                anchors.rightMargin: 10
                width: 150
                height: 50
                anchors.bottom: parent.bottom
                anchors.bottomMargin: 10

                onClicked: {
                    main_page.visible = true;
                    add_page.visible =false;
                }

                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 20
                        font.bold: true
                        color: "black"
                        text: control.text

                    }
                    background: Rectangle {
                        color: "#E1E1E1"
                        border.color: "#E1E1E1"
                        radius: width * 0.5
                    }
                }
            }
        }
    } // add page

    Page {
        id: edit_page
        visible: false
        anchors.fill: parent

        Rectangle {
            id: rectangle3_edit
            color: "#2e2d2d"
            anchors.fill: parent

            Rectangle {
                id: rectangle4_edit
                width: parent.width
                height: 40
                color: "#636161"

                Text {
                    id: text2_edit
                    color: "white"
                    text: qsTr("EDIT TASK")
                    anchors.top: parent.top
                    anchors.topMargin: 0
                    anchors.left: parent.left
                    anchors.leftMargin: 10
                    font.bold: true
                    font.pixelSize: 30
                }

            }

            Rectangle {
                id: rectangle5_edit
                color: "#2e2d2d"
                anchors.bottom: button_commit.top
                anchors.bottomMargin: 0
                anchors.right: parent.right
                anchors.rightMargin: 10
                anchors.left: parent.left
                anchors.leftMargin: 10
                anchors.top: rectangle4_edit.bottom
                anchors.topMargin: 10

                Text {
                    id: text3_edit
                    text: "Date: " + button_date.text
                    font.bold: true
                    font.underline: true
                    fontSizeMode: Text.HorizontalFit
                    font.pixelSize: 20
                    color: "white"
                }

                Text {
                    id: text4_edit
                    text: qsTr("Task:")
                    anchors.top: text3_edit.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: name_edit
                    width: 200
                    height: 30
                    anchors.top: text3_edit.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text5_edit
                    text: qsTr("City:")
                    anchors.top: text4_edit.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: city_edit
                    width: 200
                    height: 30
                    anchors.top: text4_edit.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text6_edit
                    text: qsTr("Address:")
                    anchors.top: text5_edit.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: address_edit
                    width: 200
                    height: 30
                    anchors.top: text5_edit.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text7_edit
                    text: qsTr("Time:")
                    anchors.top: text6_edit.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: time_edit
                    width: 200
                    height: 30
                    anchors.top: text6_edit.botto
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: text8_edit
                    text: qsTr("Color:")
                    anchors.top: text7_edit.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                ComboBox {
                    id: col_edit
                    width: 200
                    height: 30
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    anchors.top: text7_edit.bottom
                    anchors.topMargin: 20
                    model: ListModel
                    {
                       ListElement { text: "Blue" }
                       ListElement { text: "Red" }
                       ListElement { text: "Green" }
                       ListElement { text: "Yellow" }
                       ListElement { text: "Black" }
                       ListElement { text: "Pink" }
                       ListElement { text: "Purple" }
                   }

                    style: ComboBoxStyle {
                            id: comboBox_edit
                            background: Rectangle {
                                radius: 5
                                border.width: 2
                                color: "#fff"
                            }
                            label: Text {
                                verticalAlignment: Text.AlignVCenter
                                font.pointSize: 20
                                color: "black"
                                text: control.currentText
                            }
                        }
                }

                Text {
                    id: text9_edit
                    text: qsTr("Notes:")
                    anchors.top: text8_edit.bottom
                    anchors.topMargin: 20
                    font.pixelSize: 20
                    color: "white"
                }

                TextField {
                    id: notes_edit
                    width: 200
                    height: 80
                    anchors.top: text8_edit.bottom
                    anchors.topMargin: 20
                    anchors.right: parent.right
                    anchors.rightMargin: 20
                    font.pixelSize: 20
                    style: TextFieldStyle {
                        textColor: "black"
                        background: Rectangle {
                            radius: 2
                            implicitWidth: 100
                            implicitHeight: 24
                            border.color: "#333"
                            border.width: 1
                        }
                    }
                }

                Text {
                    id: err_edit
                    text: ""
                    color: "#cb3939"
                    font.capitalization: Font.AllUppercase
                    font.italic: true
                    anchors.horizontalCenter: parent.horizontalCenter
                    anchors.top: notes_edit.bottom
                    anchors.topMargin: 10
                    font.pixelSize: 20
                }

            }

            Button {
                id: button_commit_edit
                text: qsTr("Commit")
                anchors.left: parent.left
                anchors.leftMargin: 10
                width: 150
                height: 50
                anchors.bottom: parent.bottom
                anchors.bottomMargin: 10

                onClicked: {
                    database.updateRecord(myModel.setId(), name_edit.text, city_edit.text, address_edit.text, time_edit.text, col_edit.currentText, notes_edit.text)
                    myModel.updateModel(button_date.text)
                    main_page.visible = true;
                    edit_page.visible =false;
                    old.model = myModel.getOldTasks();
                    messages.displayMessage("Task successfully edited!");
                    notificationClient.notification = "Task edited at: " + dateClass.current_time()
                }

                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 20
                        font.bold: true
                        color: "black"
                        text: control.text

                    }
                    background: Rectangle {
                        color: "#E1E1E1"
                        border.color: "#E1E1E1"
                        radius: width * 0.5
                    }
                }
         }

            Button {
                id: button_cancel_edit
                text: qsTr("Cancel")
                anchors.right: parent.right
                anchors.rightMargin: 10
                width: 150
                height: 50
                anchors.bottom: parent.bottom
                anchors.bottomMargin: 10

                onClicked: {
                    main_page.visible = true;
                    edit_page.visible =false;
                }

                style: ButtonStyle {
                    label: Text {
                        renderType: Text.NativeRendering
                        verticalAlignment: Text.AlignVCenter
                        horizontalAlignment: Text.AlignHCenter
                        font.family: "Helvetica"
                        font.pointSize: 20
                        font.bold: true
                        color: "black"
                        text: control.text

                    }
                    background: Rectangle {
                        color: "#E1E1E1"
                        border.color: "#E1E1E1"
                        radius: width * 0.5
                    }
                }
            }
        }
    } // edit page

    InfoBanner {
        id: messages
    }

    Page {
    id: map_page
    visible: false
    anchors.fill: parent


    Rectangle {
        id: map_rectangle
        color: "#2e2d2d"
        anchors.bottomMargin: 0
        anchors.fill: parent

        Plugin {
             id: osmPlugin
             allowExperimental: true
             preferred: ["osm"]
         }

        PositionSource {
            id: src
            updateInterval: 10000
            active: true

            onPositionChanged: {
                var coord = src.position.coordinate;
                console.log("Coordinate:", coord.longitude, coord.latitude);
                map.center = coord;
                me.coordinate = coord
                /*var jamkPlace = GeocodeModel.query = "Piippukatu 2, 40100 Jyväskylä, Finland"*/
            }
        }

        Map {
            id: map
            anchors.fill: parent
            plugin: osmPlugin
            zoomLevel: 15

            MapQuickItem {
                             id: me
                             coordinate:  PositionSource.position.coordinate
                             anchorPoint.x: imageMe.width/2
                             anchorPoint.y: imageMe.height
                             sourceItem: Image {
                                 width: 50; height: 50
                                 id: imageMe
                                 source: "images/meMark.png"
                             }
                         }
                       /*MapQuickItem {
                            id: place1
                            anchorPoint.x: image1.width/2
                            anchorPoint.y: image1.height
                            sourceItem: Image {
                                width: 75; height: 75
                                id: image1
                                source: "images/marker.png"

                            }
                        }*/




            Address {

                function getAddress(){
                    var dataString = button_date.text.toString();
                    console.log("Data is : " + dataString);
                    var dataToArray = myModel.addressList(dataString).toString();
                    var dataArray = dataToArray.split(",");
                    console.log(dataArray.length);
                    var arrayLength = dataArray.length;
                    var addressList;
                    console.log(dataArray);
                    if (arrayLength > 1) {
                        var iterationAmount = arrayLength/2;
                        console.log("Will be runned " + iterationAmount);
                        var arrayPointer = 0;
                        var myStreet = dataArray[arrayPointer];
                        var myCity = dataArray[arrayPointer+1];

                        return myStreet;
                    }
                }



                id: fromAddress
                street: "Piippukatu 2"
                city: "Jyväskylä"


                Component.onCompleted: {
                    street = Qt.binding(getAddress());
                }

            }
            Address {
                id: fromAddress2
                street: "Ahjokatu 7"
                city: "Jyväskylä"
            }
            Address {
                id: fromAddress3
                street: "Ihantolantie 5"
                city: "Jyväskylä"
            }




            MapItemView {
                model: geocodeModel
                delegate: pointDelegate
            }


            Component {
                id: pointDelegate

                MapCircle {
                    id: point
                    radius: 125
                    color: "#46a2da"
                    border.color: "#190a33"
                    border.width: 2
                    smooth: true
                    opacity: 0.25
                    center: locationData.coordinate
                }
            }



            GeocodeModel {
                id: geocodeModel
                 plugin: map.plugin
                 query: fromAddress
                 onLocationsChanged:
                  {
                      geocodeModel.query = fromAddress;
                      geocodeModel.update();
                      console.log("Coordinate jamk :",   map.center.latitude + " " +  map.center.longitude);
                      /*if (count) {
                          //place1.coordinate = get(0).coordinate
                          map.center.latitude = get(0).coordinate.latitude
                          map.center.longitude = get(0).coordinate.longitude
                          console.log("Coordinate jamk :",   map.center.latitude + " " +  map.center.longitude);
                      }*/
                 }
                 Component.onCompleted: update()
            }



     }


}
    Rectangle {
         id: nav_bottom
         x: 0
         y: 0
         width: 360
         height: 300
         color: "#00000000"

         Button {
             id: back_button
             text: qsTr("Go Back")
             onClicked: {
                 main_page.visible = true;
                 map_page.visible =false;
             }
         }
     }
 }

}
/*##^## Designer {
    D{i:57;anchors_height:200;anchors_width:200;anchors_x:31;anchors_y:160}
}
 ##^##*/
