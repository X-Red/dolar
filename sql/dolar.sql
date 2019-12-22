--
-- Table structure for table `dolar`
--

CREATE TABLE IF NOT EXISTS `dolar` (
  `dolar_fecha` date NOT NULL,
  `dolar_valor` float(10,2) NOT NULL,
  `dolar_fechaact` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dolar`
--
ALTER TABLE `dolar`
 ADD PRIMARY KEY (`dolar_fecha`);
