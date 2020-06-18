<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisCoreBundle\Entity\AbstractClass;

use DateInterval;
use DateTime;
use Exception;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Exceptions\TokenInvalidException;
use OswisOrg\OswisCoreBundle\Interfaces\Common\TokenInterface;
use OswisOrg\OswisCoreBundle\Traits\AddressBook\EmailTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TypeTrait;
use OswisOrg\OswisCoreBundle\Utils\StringUtils;

/**
 * Abstract class containing basic properties for token.
 * @author Jakub Zak <mail@jakubzak.eu>
 */
abstract class AbstractToken implements TokenInterface
{
    public const DEFAULT_VALID_HOURS = 24;

    public const TYPE_ACTIVATION = 'activation';
    public const TYPE_PASSWORD_RESET = 'password-reset';
    public const TYPE_ABUSE = 'abuse';

    use BasicTrait;
    use TypeTrait;
    use EmailTrait;

    /**
     * @Doctrine\ORM\Mapping\Column(type="boolean", nullable=false)
     */
    protected bool $multipleUseAllowed = false;

    /**
     * @Doctrine\ORM\Mapping\Column(type="datetime", nullable=true)
     */
    protected ?DateTime $firstUsedAt = null;

    /**
     * @Doctrine\ORM\Mapping\Column(type="datetime", nullable=true)
     */
    protected ?DateTime $lastUsedAt = null;

    /**
     * @Doctrine\ORM\Mapping\Column(type="integer", nullable=false)
     */
    protected int $timesUsed = 0;

    /**
     * @Doctrine\ORM\Mapping\Column(type="integer", nullable=false)
     */
    protected int $validHours = self::DEFAULT_VALID_HOURS;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=false, unique=true)
     */
    protected string $token = '';

    /**
     * @throws InvalidTypeException
     */
    public function __construct(
        ?string $eMail = null,
        ?string $type = null,
        bool $multipleUseAllowed = false,
        ?int $validHours = null,
        ?int $level = null
    ) {
        $this->setMultipleUseAllowed($multipleUseAllowed);
        $this->setEmail($eMail);
        $this->setValidHours($validHours ?? self::DEFAULT_VALID_HOURS);
        $this->token = StringUtils::generateToken($level);
        $this->setType($type);
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public static function getAllowedTypesDefault(): array
    {
        return ['', self::TYPE_ACTIVATION, self::TYPE_PASSWORD_RESET, self::TYPE_ABUSE];
    }

    public static function getAllowedTypesCustom(): array
    {
        return [];
    }

    public function getToken(): string
    {
        return ''.$this->token;
    }

    public function canBeUsed(): bool
    {
        if (!$this->isValidAt()) {
            return false;
        }
        if ($this->isUsed() && !$this->isMultipleUseAllowed()) {
            return false;
        }

        return true;
    }

    public function isValidAt(?DateTime $dateTime = null): bool
    {
        return $this->getValidUntil() > ($dateTime ?? new DateTime());
    }

    public function getValidUntil(): DateTime
    {
        $dateTime = clone $this->getCreatedAt();
        $validHours = $this->getValidHours();
        try {
            $dateTime->add(new DateInterval('PT'.$validHours.'H'));
        } catch (Exception $e) {
        }

        return $dateTime;
    }

    public function getValidHours(): int
    {
        return $this->validHours;
    }

    public function setValidHours(int $hours): void
    {
        $this->validHours = $hours;
    }

    public function isUsed(): bool
    {
        return $this->getTimesUsed() > 0 || $this->getFirstUsedAt();
    }

    public function getTimesUsed(): int
    {
        return $this->timesUsed;
    }

    public function getFirstUsedAt(): ?DateTime
    {
        return $this->firstUsedAt;
    }

    public function isMultipleUseAllowed(): bool
    {
        return $this->multipleUseAllowed;
    }

    public function setMultipleUseAllowed(bool $multipleUseAllowed): void
    {
        $this->multipleUseAllowed = $multipleUseAllowed;
    }

    /**
     * @throws TokenInvalidException
     */
    public function use(bool $simulate = false): void
    {
        if (!$this->isValidAt()) {
            throw new TokenInvalidException('platnost tokenu vypršela');
        }
        if ($this->isUsed() && !$this->isMultipleUseAllowed()) {
            throw new TokenInvalidException('token již byl použitý');
        }
        if (!$simulate) {
            $this->setUsed();
        }
    }

    public function setUsed(): void
    {
        $now = new DateTime();
        $this->timesUsed++;
        $this->firstUsedAt ??= $now;
        $this->lastUsedAt ??= $now;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getLastUsedAt(): ?DateTime
    {
        return $this->lastUsedAt;
    }
}