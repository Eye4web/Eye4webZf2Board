<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace E4W\Zf2Board\Service;

use \E4W\Zf2Board\Service\SlugServiceInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class SlugService implements EventManagerAwareInterface, SlugServiceInterface
{
    use EventManagerAwareTrait;

    /**
     * @param $slug
     * @param string $delimiter
     * @return string
     */
    public function generate($slug, $delimiter = '-')
    {
        // Replace non letter or digits by delimiter
        $slug = preg_replace('~[^\\pL\d]+~u', $delimiter, $slug);

        // Trim
        $slug = trim($slug, $delimiter);

        // Transliterate
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

        // Lowercase
        $slug = strtolower($slug);

        // Remove unwanted characters
        $slug = preg_replace('~[^-\w]+~', '', $slug);

        if (empty($slug)) {
            return uniqid();
        }

        return $slug;
    }
}
