import QtQuick.Controls 2.4
import QtQuick.Layouts 1.1
import QtQuick.Dialogs 1.2
import QtQuick.Controls.Styles 1.2
import QtQuick 2.9
import QtQuick.Window 2.2
import QtQuick.Controls 1.4
import QtQuick.Layouts 1.3

Loader {
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
    }
