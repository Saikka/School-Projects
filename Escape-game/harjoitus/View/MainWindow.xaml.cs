using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using harjoitus.Model;
using System.Runtime.Serialization.Formatters.Binary;
using System.Runtime.Serialization;
using System.Xml.Serialization;
using System.Media;

namespace harjoitus.View
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        Huone huone = new Model.Huone();
        SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
        public MainWindow()
        {
            InitializeComponent();
        }

        private void btnNewGame_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            huone.IsSavedGame = false;
            Toiminta.Save(huone);
            UusiPeli game = new harjoitus.View.UusiPeli();
            this.Close();
            game.ShowDialog();
        }

        private void btnExit_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            this.Close();
        }

        private void btnLoadGame_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            huone = Toiminta.ReadFromFile();
            if (huone.IsSavedGame == false)
                MessageBox.Show("No saved game!");
            else
                switch (huone.RoomNumber)
                {
                    case 1:
                        huone1 huone1 = new harjoitus.View.huone1();
                        this.Close();
                        huone1.ShowDialog();
                        break;
                    case 2:
                        huone2 huone2 = new harjoitus.View.huone2();
                        this.Close();
                        huone2.ShowDialog();
                        break;
                    case 3:
                        huone3 huone3 = new harjoitus.View.huone3();
                        this.Close();
                        huone3.ShowDialog();
                        break;
                    case 4:
                        huone4 huone4 = new harjoitus.View.huone4();
                        this.Close();
                        huone4.ShowDialog();
                        break;
                    case 5:
                        huone5 huone5 = new harjoitus.View.huone5();
                        this.Close();
                        huone5.ShowDialog();
                        break;
                }
        }
    }
}
