<?php
class Bnr {
    private $data;
    
    /**
     * The original source
     */
    const BNR_FEED = 'http://www.bnro.ro/nbrfxrates.xml';
    
    /**
     * Translate these values in your own language
     */
    private $names = array('EUR' => 'Euro');
    
    public function __construct() {
        $this->data = $this->parseFeed();
    }
    
    /**
     * Parse and load the XML feed
     * @return object
     */
    private function parseFeed() {
       $xml = simplexml_load_file(self::BNR_FEED);
       
       return $xml->Body->Cube->Rate;
    }
    
    /**
     * Get the currencies: symbols and values (multipliers, also, if it is the case)
     * @return array
     */
    public function getCurrencies() {
        $result = array();
        
        for($i = 0; $i < count($this->data); $i++) {
            if((string) $this->data[$i]->attributes()->multiplier != '') {
                $result[(string) $this->data[$i]->attributes()->multiplier.' '.(string) $this->data[$i]->attributes()->currency] = (string) $this->data[$i];
            } else {
                $result[(string) $this->data[$i]->attributes()->currency] = (string) $this->data[$i];
            }
        }
        
        return $result;
    }
    
    /**
     * Get the value of a single currency
     * @return string
     * @param $symbol string
     */
    public function getCurrencyValue($symbol) {
        $currencies = $this->getCurrencies();
        
        return $currencies[$symbol];
    }
    
    /**
     * Get the full name of a currency
     * @return string | array
     * @param $symbol string[optional]
     */
    public function getCurrencyName($symbol = '') {
        return $symbol != '' ? $this->names[$symbol] : $this->names;
    }
}