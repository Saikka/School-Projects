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
using System.Media;

namespace harjoitus.View
{
    /// <summary>
    /// Interaction logic for UusiPeli.xaml
    /// </summary>
    public partial class UusiPeli : Window
    {
        SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
        public UusiPeli()
        {
            InitializeComponent();
        }

        private void btnNew_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            huone1 h = new harjoitus.View.huone1();
            this.Close();
            h.ShowDialog();
        }

        private void btnLoadGame_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            MainWindow no = new harjoitus.View.MainWindow();
            this.Close();
            no.ShowDialog();
        }
    }
}
