<?php
/**
 * replaces standard file-based sessions with a MongoDb backend
 *
 */
class AiQRCode_MongoSession implements Zend_Session_SaveHandler_Interface
{
    /**
     * @var MongoCollection
     */
    private $_collection;

    /**
     * @var array
     */
    private $_session;

    /**
     * Constructor
     *
     * @param MongoCollection $collection
     */
    public function __construct($collection)
    {
        if (!$collection instanceof MongoCollection)
        {
            throw new Exception(sprintf(
                'Argument 1 must be an instance of MongoCollection. Instance of %s given',
                get_class($collection)
            ));
        }

        $this->_collection = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function open($save_path, $session_name)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($id)
    {
        if (! isset($this->_session)) {
            $this->_session = $this->_collection->findOne(array('s' => $id));
        }

        if ($this->_session) {
            return $this->_session['d'];
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function write($id, $data)
    {
        if (! isset($this->_session)) {
            $this->_session = array(
                'ts' => new MongoDate(),
                's' => $id,
                't' => time(),
                'd' => ''
            );
        }

        // Is new data differet from data we already have? Then save it!
        if ($this->_session['d'] != $data) {
            $this->_session['d'] = $data;
            $this->_collection->save($this->_session);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        $this->_collection->remove(array('s' => $id));
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        $this->_collection->remove(array(
            't' => array('$lt' => time() - $maxlifetime)
        ));
    }
}
