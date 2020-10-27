using System;
using System.Collections.Generic;
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
using System.Windows.Shapes;
using harjoitus;
using System.Media;

namespace harjoitus.View
{
    /// <summary>
    /// Interaction logic for PelinLopetus.xaml
    /// </summary>
    public partial class PelinLopetus : Window
    {
        SoundPlayer tada = new System.Media.SoundPlayer(Properties.Resources.tada);
        SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
        public PelinLopetus()
        {
            InitializeComponent();
            tada.Play();
        }

        private void btnExit_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            MainWindow game = new harjoitus.View.MainWindow();
            this.Close();
            game.ShowDialog();
        }
    }
}
